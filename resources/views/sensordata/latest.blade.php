<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Sensor Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta http-equiv="refresh" content="5"> -->

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        h1 {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4">Live Sensor Data</h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-4 text-center bg-light">
                <h5>Temperature</h5>
                <h2 id="temperature">-- °C</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center bg-light">
                <h5>Humidity</h5>
                <h2 id="humidity">-- %</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center bg-light">
                <h5>Water Level</h5>
                <h2 id="water_level">-- cm</h2>
            </div>
        </div>
    </div>

    <div class="card mt-5 p-4">
        <h5 class="mb-3">Live Graph</h5>
        <canvas id="sensorChart" height="100"></canvas>
    </div>
</div>

<script>
    let chart;
    let timeLabels = [];
    let tempData = [];
    let humData = [];
    let levelData = [];

    function fetchLatestData() {
        $.getJSON("/sensor/latest-json", function(data) {
            if (data) {
                $('#temperature').text(data.temperature + ' °C');
                $('#humidity').text(data.humidity + ' %');
                $('#water_level').text(data.water_level + ' cm');

                const timestamp = new Date(data.created_at).toLocaleTimeString();

                // Only keep last 10 data points
                if (timeLabels.length >= 10) {
                    timeLabels.shift();
                    tempData.shift();
                    humData.shift();
                    levelData.shift();
                }

                timeLabels.push(timestamp);
                tempData.push(data.temperature);
                humData.push(data.humidity);
                levelData.push(data.water_level);

                updateChart();
            }
        });
    }

    function updateChart() {
        chart.data.labels = timeLabels;
        chart.data.datasets[0].data = tempData;
        chart.data.datasets[1].data = humData;
        chart.data.datasets[2].data = levelData;
        chart.update();
    }

    $(document).ready(function() {
        // Initialize chart
        const ctx = document.getElementById('sensorChart').getContext('2d');
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Temperature (°C)',
                        data: [],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Humidity (%)',
                        data: [],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Water Level (cm)',
                        data: [],
                        borderColor: 'rgba(255, 206, 86, 1)',
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                animation: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Initial fetch and then every 3 seconds
        fetchLatestData();
        setInterval(fetchLatestData, 3000);
    });
</script>
</body>
</html>

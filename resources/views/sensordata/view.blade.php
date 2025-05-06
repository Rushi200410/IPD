<!DOCTYPE html>
<html>
<head>
    <title>Latest Sensor Data</title>
</head>
<body>
    <h1>Latest Sensor Data</h1>

    @if($latestData)
        <p><strong>ID:</strong> {{ $latestData->id }}</p>
        <p><strong>Temperature:</strong> {{ $latestData->temperature }}</p>
        <p><strong>Water Level:</strong> {{ $latestData->water_level }}</p>
        <p><strong>Recorded At:</strong> {{ $latestData->created_at }}</p>
    @else
        <p>No data available.</p>
    @endif
</body>
</html>

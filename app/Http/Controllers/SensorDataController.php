<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
        // Log the incoming data for debugging
        \Log::info('Received data from ESP32:', $request->all());

        // Validate the incoming data
        $data = $request->validate([
            'water_level' => 'required|numeric',
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
        ]);

        // Check if data is valid
        \Log::info('Validated data:', $data);

        // Save to the database
        try {
            SensorData::create($data);
            return response()->json(['message' => 'Data stored successfully']);
        } catch (\Exception $e) {
            \Log::error('Error storing data:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to store data', 'error' => $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorData;

class SeeDataController extends Controller
{
    public function showLatest()
    {
        $latestData = SensorData::latest()->first(); // gets latest row by created_at or id

        return view('sensordata.latest', compact('latestData'));
        // return view('sensordata.view', compact('latestData'));
    }

    public function latestJson()
    {
        $latestData = \App\Models\SensorData::latest()->first();
        return response()->json($latestData);
    }

}

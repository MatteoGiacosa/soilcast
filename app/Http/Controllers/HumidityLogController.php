<?php

namespace App\Http\Controllers;

use App\Models\HumidityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HumidityLogController extends Controller
{

    public function index()
    {
        $logs = HumidityLog::all();
        return response()->json($logs, 200);
    }

    public function store(Request $request)
    {
        // validate the request data
        $request->validate([
            'humidity' => 'required|integer',
            'recorded_at' => 'required|date',
            'sensor_id' => 'required|integer|exists:sensors,id', // adding sensor_id validation
        ]);

        // create a new log
        $log = HumidityLog::create($request->only('humidity', 'recorded_at', 'sensor_id')); // including sensor_id

        // log the data
        Log::info('New humidity log: ', ['humidity' => $log->humidity, 'recorded_at' => $log->recorded_at, 'sensor_id' => $log->sensor_id]); // logging sensor_id

        // return a response
        return response()->json(['message' => 'Humidity log created successfully.'], 201);
    }

}

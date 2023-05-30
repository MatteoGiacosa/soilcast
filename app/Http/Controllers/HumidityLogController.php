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
            'mac' => 'required|string',
            'humidity' => 'required|integer',
            'battery' => 'required|integer',
            'recorded_at' => 'required|date',
            'sensor_id' => 'required|integer|exists:sensors,id', 
        ]);

        // create a new log
        $log = HumidityLog::create($request->only('mac', 'humidity', 'battery', 'recorded_at', 'sensor_id'));

        // log the data
        Log::info('New humidity log: ', ['mac' => $log->mac, 'humidity' => $log->humidity, 'battery' => $log->battery, 'recorded_at' => $log->recorded_at, 'sensor_id' => $log->sensor_id]);

        // return a response
        return response()->json(['message' => 'Humidity log created successfully.'], 201);
    }

}

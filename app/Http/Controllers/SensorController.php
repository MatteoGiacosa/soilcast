<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Http\Requests\StoreZoneRequest;

class SensorController extends Controller
{
    public function index()
    {
        $sensors = Sensor::all();
        return response()->json($sensors);
    }

    public function show($id)
    {
        $sensor = Sensor::with('zone')->find($id);

        return response()->json([
            'sensor' => $sensor,
            'zoneName' => $sensor->zone->zoneName,
        ]);
    }

public function store(StoreZoneRequest $request)
{
    $zone = Zone::where('zoneName', $request->zoneName)->firstOrFail();

    $sensor = new Sensor;
    $sensor->connected = $request->connected;
    $sensor->battery = $request->battery;
    $sensor->humidityPercentage = $request->humidityPercentage;
    $sensor->latestDataCollection = $request->latestDataCollection;
    $sensor->control_unit_id = $zone->control_unit_id;
    $sensor->zone_id = $zone->id;
    $sensor->save();

    return response()->json($sensor);
}




    public function update(Request $request, Sensor $sensor)
    {
        $validatedData = $request->validate([
            'connected' => 'sometimes|required|boolean',
            'battery' => 'sometimes|required|numeric',
            'humidityPercentage' => 'sometimes|required|numeric',
            'latestDataCollection' => 'sometimes|required|date_format:H:i:s',
        ]);

        $sensor->update($validatedData);
        return response()->json($sensor);
    }

    public function destroy(Sensor $sensor)
    {
        $sensor->delete();
        return response()->json(null, 204);
    }
}

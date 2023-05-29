<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use Illuminate\Support\Facades\Storage;



class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::all();
        return response()->json(['data' => $zones]);
    }

    public function show(Zone $zone)
    {
        return response()->json(['data' => $zone]);
    }

    public function store(Request $request)
    {
        $zone = new Zone;
        $zone->zoneName = $request->input('zoneName');
        $zone->connected = $request->input('connected');
    
        // Store the image and save the URL in the database
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/images');
            $zone->image = Storage::url($imagePath);
        }
    
        $zone->nextWatering = $request->input('nextWatering');
        $zone->lastWatering = $request->input('lastWatering');
        $zone->latWateringStart = $request->input('latWateringStart');
        $zone->control_unit_id = $request->input('control_unit_id');
        $zone->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Zone created successfully',
            'zone' => $zone
        ], 201);
    }    

    public function update(Request $request, Zone $zone)
    {
        $validatedData = $request->validate([
            'zoneName' => 'max:255',
            'connected' => 'boolean',
            'image' => 'nullable',
            'nextWatering' => 'nullable',
            'lastWatering' => 'nullable',
            'latWateringStart' => 'nullable',
            'control_unit_id' => 'exists:control_units,id',
        ]);
    
        $validatedData['zoneName'] = $request->input('zoneName');
    
        $zone->update($validatedData);
    
        return response()->json(['data' => $zone], 200);
    }
    

    public function destroy(Zone $zone)
    {
        $zone->delete();

        return response()->json(['data' => null], 204);
    }

    public function getUserZones($userId)
    {
        // Find the user by id
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Get all zones of the user via control units
        $zones = [];
        foreach ($user->controlUnits as $controlUnit) {
            foreach ($controlUnit->zones as $zone) {
                $zones[] = $zone;
            }
        }

        return response()->json(['data' => $zones]);
    }

}

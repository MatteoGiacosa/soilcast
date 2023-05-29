<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function updatePreferences(Request $request)
    {
        // validate the request data
        $data = $request->validate([
            'user_id' => 'required|exists:users,id', // assuming you are passing user's id
            'irrigation_status' => 'required|boolean',
            'sensor_low_battery' => 'required|boolean',
            'no_signal' => 'required|boolean',
        ]);

        // find the user and update the preferences
        $user = User::findOrFail($data['user_id']);
        $user->update([
            'irrigation_status' => $data['irrigation_status'],
            'sensor_low_battery' => $data['sensor_low_battery'],
            'no_signal' => $data['no_signal'],
        ]);

        // return a response
        return response()->json(['message' => 'Preferences updated successfully.']);
    }
}

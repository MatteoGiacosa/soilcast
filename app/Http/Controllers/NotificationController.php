<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OneSignalService;

class NotificationController extends Controller
{
    protected $oneSignalService;

    public function __construct(OneSignalService $oneSignalService)
    {
        $this->oneSignalService = $oneSignalService;
    }

    public function getPreferences(Request $request)
    {
        // Assuming user_id is authenticated
        $userId = $request->user()->id;

        $user = User::findOrFail($userId);
        return response()->json($user->only('irrigation_status', 'sensor_low_battery', 'no_signal'));
    }

    public function updatePreferences(Request $request)
    {
        $data = $request->validate([
            'irrigation_status' => 'required|boolean',
            'sensor_low_battery' => 'required|boolean',
            'no_signal' => 'required|boolean',
        ]);

        $userId = $request->user()->id;
        $user = User::findOrFail($userId);
        $user->update($data);

        return response()->json(['message' => 'Preferences updated successfully.']);
    }

    public function createNotification(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'users' => 'required|array', // assuming you are passing an array of user_ids to send notification to
        ]);

        $notificationData = [
            'headings' => [
                'en' => $data['title'],
            ],
            'contents' => [
                'en' => $data['message'],
            ],
            'include_player_ids' => $data['users'],
        ];

        $this->oneSignalService->sendNotification($notificationData);

        return response()->json(['message' => 'Notification sent successfully.']);
    }
}

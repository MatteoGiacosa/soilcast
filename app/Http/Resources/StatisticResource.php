<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\WeatherController;

class StatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $weatherController = new WeatherController();
        $response = $weatherController->fetchWeatherByCoordinates($request);
        $weatherData = $response->json();

        $weather = $weatherData['temperature'];

        return [
            'live_statistics' => [
                'humidity' => $liveStatistics['humidity'],
                'weather' => $weather,
            ],
            'weekly_statistics' => [
                'humidity' => $weeklyStatistics['humidity'],
                'weather' => $weather,
            ],
        ];
    }
}
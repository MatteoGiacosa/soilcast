<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function fetchWeatherByCoordinates(Request $request)
    {
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');
        $apiKey = 'f4b6f7094c0e4bd9e24f56f5dff387ee';
        $url = "http://api.openweathermap.org/data/2.5/weather?lat={$latitude}&lon={$longitude}&appid={$apiKey}&units=metric";
        try {
            $response = Http::get($url);
            if($response->successful()) {
                $weatherData = $response->json();
                $temperature = round($weatherData['main']['temp']) . "°C";
                $weatherIcon = $weatherData['weather'][0]['icon'] ?? "";
                return response()->json([
                    'temperature' => $temperature,
                    'weatherIcon' => $weatherIcon,
                ]);
            }
            return response()->json(['message' => 'Failed to fetch weather data'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving weather data'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeatherData($controlUnitId, $zipCode, $countryCode)
    {
        $geolocationResponse = Http::get('http://api.openweathermap.org/geo/1.0/zip', [
            'zip' => $zipCode.','.$countryCode,
            'appid' => 'f4b6f7094c0e4bd9e24f56f5dff387ee',
        ]);

        if (!$geolocationResponse->successful()) {
            return response()->json(['error' => 'Unable to get geolocation data'], 500);
        }

        $geolocationData = $geolocationResponse->json();

        $weatherResponse = Http::get('http://api.openweathermap.org/data/2.5/weather', [
            'lat' => $geolocationData['lat'],
            'lon' => $geolocationData['lon'],
            'appid' => 'f4b6f7094c0e4bd9e24f56f5dff387ee',
        ]);

        if (!$weatherResponse->successful()) {
            return response()->json(['error' => 'Unable to get weather data'], 500);
        }

        $weatherData = Weather::create([
            'zip_code' => $zipCode,
            'country_code' => $countryCode,
            'lat' => $geolocationData['lat'],
            'lon' => $geolocationData['lon'],
            'data' => $weatherResponse->json(),
            'control_unit_id' => $controlUnitId,
        ]);

        return response()->json($weatherData, 200);
    }


}

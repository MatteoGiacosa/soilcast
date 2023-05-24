<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\StatisticResource;
use App\Models\Statistic;
use App\Models\Sensor;
use Illuminate\Http\JsonResponse;
use GuzzleHttp\Client;

class StatisticController extends Controller
{
    public function index(): JsonResponse
    {
        $statistics = Statistic::all();

        return response()->json([
            'message' => 'Statistics retrieved successfully',
            'data' => StatisticResource::collection($statistics),
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $statistic = Statistic::findOrFail($id);

        return response()->json([
            'message' => 'Statistic retrieved successfully',
            'data' => new StatisticResource($statistic),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'collectionTime' => 'required|date_format:H:i:s',
            'humidity' => 'required|numeric',
            'sensor_id' => 'required|exists:sensors,id',
        ]);

        $statistic = Statistic::create($validatedData);

        return response()->json([
            'message' => 'Statistic created successfully',
            'data' => new StatisticResource($statistic),
        ], 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $validatedData = $request->validate([
            'collectionTime' => 'required|date_format:H:i:s',
            'humidity' => 'required|numeric',
            'sensor_id' => 'required|exists:sensors,id',
        ]);

        $statistic = Statistic::findOrFail($id);
        $statistic->update($validatedData);

        return response()->json([
            'message' => 'Statistic updated successfully',
            'data' => new StatisticResource($statistic),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $statistic = Statistic::findOrFail($id);
        $statistic->delete();

        return response()->json([
            'message' => 'Statistic deleted successfully',
        ]);
    }

    public function getStatistics(): JsonResponse
    {
        $liveStatistics = $this->getLiveStatistics();
        $weeklyStatistics = $this->getWeeklyStatistics();

        $statisticData = new StatisticDataResource([
            'liveStatistics' => $liveStatistics,
            'weeklyStatistics' => $weeklyStatistics,
        ]);

        return response()->json([
            'message' => 'Statistic data retrieved successfully',
            'data' => $statisticData,
        ]);
    }

    private function getLiveStatistics(): array
    {
        $temperature = $this->getTemperatureFromWeatherAPI();
        $weather = $this->getWeatherFromWeatherAPI();
        $humidity = $this->getHumidityFromSensor($sensorId);

        return [
            'humidity' => $humidity,
            'weather' => $weather,
        ];
    }

    private function getTemperatureFromWeatherAPI(): float
    {
        $client = new Client();
    
        try {
            $response = $client->get('http://api.openweathermap.org/data/2.5/weather?lat={latitude}&lon={longitude}&appid={api_key}&units=metric');
            $weatherData = json_decode($response->getBody(), true);
    
            $temperature = round($weatherData['main']['temp']);
    
            return $temperature;
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    private function getWeatherFromWeatherAPI(): string
    {
        $client = new Client();
    
        try {
            $response = $client->get('http://api.openweathermap.org/data/2.5/weather?lat={latitude}&lon={longitude}&appid={api_key}&units=metric');
            $weatherData = json_decode($response->getBody(), true);
    
            $weather = $weatherData['weather'][0]['icon'] ?? "";
    
            return $weather;
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
    
    private function getHumidityFromSensor($sensorId): float
    {
        $sensor = Sensor::find($sensorId);
    
        if ($sensor) {
            return $sensor->humidity;
        }
    
        return 0;
    }
}
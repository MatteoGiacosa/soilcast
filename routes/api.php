<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ControlUnitController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\AuthController;

use App\Models\ControlUnit;
use App\Models\Sensor;
use App\Models\Statistic;
use App\Models\User;
use App\Models\Zone;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Laravel Sanctum
Route::post('/register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//controlUnit
Route::get('/controlUnits', function () {
    $controlUnits = ControlUnit::all();

    return response()->json([
        'controlUnits' => $controlUnits
    ]);
});

Route::post('/controlUnits', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'address' => 'required',
        'city' => 'required',
        'cap' => 'required',
        'country' => 'required',
        'user_id' => 'required|exists:users,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'The data provided is not valid',
            'errors' => $validator->errors(),
        ], 422);
    }

    $controlUnit = new ControlUnit;
    $controlUnit->name = $request->input('name');
    $controlUnit->address = $request->input('address');
    $controlUnit->city = $request->input('city');
    $controlUnit->cap = $request->input('cap');
    $controlUnit->country = $request->input('country');
    $controlUnit->user_id = $request->input('user_id'); // Add this line
    $controlUnit->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Control unit created successfully',
        'controlUnit' => $controlUnit
    ]);
});


Route::get('/controlUnits/{id}', function ($id) {
    $controlUnit = ControlUnit::findOrFail($id);

    return response()->json([
        'status' => 'success',
        'controlUnit' => $controlUnit
    ]);
});

Route::put('/controlUnits/{id}', function (Request $request, $id) {
    $controlUnit = ControlUnit::findOrFail($id);
    $controlUnit->address = $request->input('address');
    $controlUnit->city = $request->input('city');
    $controlUnit->cap = $request->input('cap');
    $controlUnit->country = $request->input('country');
    $controlUnit->save();

    return response()->json([
        'status' => 'success',
        'controlUnit' => $controlUnit
    ]);
});

Route::delete('/controlUnits/{id}', function ($id) {
    $controlUnit = ControlUnit::findOrFail($id);
    $controlUnit->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Control unit deleted successfully'
    ]);
});


//zone
Route::get('/zones', [ZoneController::class, 'index']);
Route::get('/zones/{zone}', [ZoneController::class, 'show']);
Route::post('/zones', [ZoneController::class, 'store']);
Route::put('/zones/{zone}', [ZoneController::class, 'update']);
Route::delete('/zones/{zone}', [ZoneController::class, 'destroy']);
Route::get('/zones/user/{userId}', [ZoneController::class, 'getUserZones']);



//sensori
Route::get('/sensors', function () {
    $sensors = Sensor::all();
    return response()->json($sensors);
});

Route::post('/sensors', function (Request $request) {
    $zone = Zone::find($request->zone_id);
    if (!$zone) {
        return response()->json(['error' => 'Zone not found'], 404);
    }
    
    $sensor = new Sensor;
    $sensor->connected = $request->connected;
    $sensor->battery = $request->battery;
    $sensor->humidityPercentage = $request->humidityPercentage;
    $sensor->latestDataCollection = $request->latestDataCollection;
    $sensor->control_unit_id = $request->control_unit_id;
    $sensor->zone_id = $zone->id;
    
    $sensor->save();
    return response()->json($sensor);
});


Route::get('/sensors/{id}', function ($id) {
    $sensor = Sensor::findOrFail($id);
    return response()->json($sensor);
});

Route::put('/sensors/{id}', function (Request $request, $id) {
    $sensor = Sensor::findOrFail($id);
    $sensor->connected = $request->connected;
    $sensor->battery = $request->battery;
    $sensor->humidityPercentage = $request->humidityPercentage;
    $sensor->latestDataCollection = $request->latestDataCollection;
    $sensor->save();
    return response()->json($sensor);
});

Route::delete('/sensors/{id}', function ($id) {
    $sensor = Sensor::findOrFail($id);
    $sensor->delete();
    return response()->json(['message' => 'Sensor deleted successfully']);
});

//statistic
Route::get('/statistics', [StatisticController::class, 'index']);
Route::get('/statistics/{id}', [StatisticController::class, 'show']);
Route::post('/statistics', [StatisticController::class, 'store']);
Route::put('/statistics/{id}', [StatisticController::class, 'update']);
Route::delete('/statistics/{id}', [StatisticController::class, 'destroy']);

Route::get('/weather', [WeatherController::class, 'fetchWeatherByCoordinates']);
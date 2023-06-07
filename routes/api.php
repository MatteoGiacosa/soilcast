<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Services\OneSignalService;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ControlUnitController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HumidityLogController;
use App\Http\Controllers\NotificationController;

use App\Models\ControlUnit;
use App\Models\Sensor;
use App\Models\Statistic;
use App\Models\User;
use App\Models\Zone;
use App\Models\HumidityLog;
use App\Models\Weather;


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
Route::delete('/user/{id}', [UserController::class, 'destroy'])->middleware('auth:sanctum');


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
Route::get('/storage/images/{filename}', function ($filename)
{
    $path = storage_path('app/public/images/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

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
    $sensor->mac = $request->mac;
    $sensor->minHumidity = $request->minHumidity;
    $sensor->maxHumidity = $request->maxHumidity;
    $sensor->DataCollection = $request->DataCollection;
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
    $sensor->mac = $request->mac;
    $sensor->minHumidity = $request->minHumidity;
    $sensor->maxHumidity = $request->maxHumidity;
    $sensor->DataCollection = $request->DataCollection;
    $sensor->save();
    return response()->json($sensor);
});

Route::delete('/sensors/{id}', function ($id) {
    $sensor = Sensor::findOrFail($id);
    $sensor->delete();
    return response()->json(['message' => 'Sensor deleted successfully']);
});

Route::put('/sensors/{sensor}', [SensorController::class, 'update']);
Route::patch('/sensors/{sensor}', [SensorController::class, 'partialUpdate']);



//statistic
Route::get('/statistics', [StatisticController::class, 'index']);
Route::get('/statistics/{id}', [StatisticController::class, 'show']);
Route::post('/statistics', [StatisticController::class, 'store']);
Route::put('/statistics/{id}', [StatisticController::class, 'update']);
Route::delete('/statistics/{id}', [StatisticController::class, 'destroy']);

Route::get('/weather/{controlUnitId}/{zip}/{country}', [WeatherController::class, 'getWeatherData']);
Route::get('/weather/history', [WeatherController::class, 'getWeatherHistory']);

//logs
Route::get('/humidity-logs', [HumidityLogController::class, 'index']);
Route::post('/humidity-logs', [HumidityLogController::class, 'store']);

//notifications
Route::get('/get-notification-preferences', [NotificationController::class, 'getPreferences'])->middleware('auth:sanctum');
Route::post('/update-notification-preferences', [NotificationController::class, 'updatePreferences']);
Route::post('/create-notification', [NotificationController::class, 'createNotification']);

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WeatherController;
use App\Models\ControlUnit;
use App\Models\WeatherHistory;

class FetchWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the weather data for each control unit every hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $controlUnits = ControlUnit::all(); // Assuming ControlUnit model exists
    
            foreach($controlUnits as $controlUnit) {
                // Use the getWeatherData method of WeatherController
                app(WeatherController::class)->getWeatherData($controlUnit->id, $controlUnit->zip_code, $controlUnit->country_code);
            }
    
            $this->info('Weather data has been fetched for all control units.');
    
        } catch (\Exception $e) {
            Log::error('Failed to fetch weather data', ['error' => $e->getMessage()]);
        }
    }    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'weather_id',
        'temperature',
        'recorded_at',
    ];

    public function weather()
    {
        return $this->belongsTo(Weather::class);
    }
}


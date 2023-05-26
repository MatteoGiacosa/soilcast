<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumidityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'humidity',
        'recorded_at',
        'sensor_id'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
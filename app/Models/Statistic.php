<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'collectionTime',
        'humidity',
        'sensor_id'
    ];

    public function statistic()
    {
        return $this->belongsTo(Sensor::class);
    }
}

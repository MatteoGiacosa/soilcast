<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'valueDate',
        'sensor_id'
    ];

    public function statistic()
    {
        return $this->belongsTo(Sensor::class);
    }
}

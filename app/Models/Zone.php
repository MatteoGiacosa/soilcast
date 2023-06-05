<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    protected $fillable = ['zoneName', 'connected', 'image', 'nextWatering', 'lastWatering', 'latWateringStart', 'control_unit_id', 'sensor_id'];
    protected $with = array('sensors');

    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }

    public function controlUnit()
    {
        return $this->belongsTo(ControlUnit::class);
    }

    public function sensor()
    {
        return $this->hasOne(Sensor::class);
    }
}

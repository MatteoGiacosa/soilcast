<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'mac',
        'battery',
        'humidityPercentage',
        'latestDataCollection',
        'control_unit_id',
        'zone_id'
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function getZoneNameAttribute()
    {
        return $this->zone->zoneName;
    }

    public function notifications()
    {
        return $this->hasMany(Notifications::class);
    }

    public function statistics()
    {
        return $this->hasMany(Statistic::class);
    }
}

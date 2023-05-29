<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherHistory extends Model
{
    use HasFactory;

    public function weather()
    {
        return $this->belongsTo(Weather::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlUnit extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'city', 'cap', 'country', 'user_id'];
    protected $with = array('zones');

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function weather()
    {
        return $this->hasOne(Weather::class);
    }
}
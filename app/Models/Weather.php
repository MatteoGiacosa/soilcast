<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $table = 'weathers'; // Specify the table name here

    protected $fillable = ['zip_code', 'country_code', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    public function controlUnit()
    {
        return $this->belongsTo(ControlUnit::class);
    }
}

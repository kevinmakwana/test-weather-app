<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityWeather extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'temperature', 'min_temperature', 'max_temperature', 'humidity', 'wind_speed'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'latitude', 'longitude'];

    public function cityWeathers()
    {
        return $this->hasMany(CityWeather::class);
    }

    public function cityWeathersForcasts()
    {
        return $this->hasMany(WeatherForecast::class);
    }
}

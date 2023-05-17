<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherForecast extends Model
{
    use HasFactory;

    protected $table = 'weather_forecasts';

    protected $fillable = [
        'city_id',
        'city',
        'forecast_data',
    ];
}

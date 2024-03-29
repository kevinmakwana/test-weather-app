<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CityWeatherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('weather/{city}', [CityWeatherController::class, 'getWeatherDetails']);
Route::get('weather-forcast/{city}', [CityWeatherController::class, 'getWeatherForcastDetails']);

Route::post('cities', [CityController::class, 'create']);

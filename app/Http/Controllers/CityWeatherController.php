<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\OpenWeatherMapService;
use GuzzleHttp\Client;

class CityWeatherController extends Controller
{
    //
    public function getWeatherDetails($city)
    {
        $city = City::whereName($city)->firstOrFail();

        $openWeatherMapService = new OpenWeatherMapService((new Client));

        $weatherData = $openWeatherMapService->getWeatherForCity($city->name);

        $response = $city->cityWeathers()->create([
            'temperature' => $weatherData['main']['temp'],
            'min_temperature' => $weatherData['main']['temp_min'],
            'max_temperature' => $weatherData['main']['temp_max'],
            'humidity' => $weatherData['main']['humidity'],
            'wind_speed' => $weatherData['wind']['speed'],
        ]);

        return response()->json($response, 200);
    }

    public function getWeatherForcastDetails($city)
    {
        $city = City::whereName($city)->firstOrFail();

        $openWeatherMapService = new OpenWeatherMapService((new Client));

        $forecastData = $openWeatherMapService->getFiveDayWeatherForecast($city->name);

        $response = $city->cityWeathersForcasts()->create([
            'city' => $city->name,
            'forecast_data' => json_encode($forecastData),
        ]);

        return response()->json($response, 200);
    }
}

<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\CityWeather;
use App\Models\WeatherForecast;
use App\Services\OpenWeatherMapService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class CityWeatherTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // You can set up any necessary dependencies or mock objects here
    }

    public function testGetWeatherForCity()
    {

        // Mocking the GuzzleHttp\Client
        $httpClientMock = $this->createMock(Client::class);
        $this->app->instance(Client::class, $httpClientMock);

        // Creating a mock response
        $responseBody = json_encode([
            'weather' => [
                [
                    'id' => 800,
                    'main' => 'Clear',
                    'description' => 'clear sky',
                    'icon' => '01d',
                ],
            ],
            'main' => [
                'temp' => 301.06,
                'temp_min' => 301.06,
                'temp_max' => 301.06,
                'pressure' => 1008,
                'humidity' => 72,
            ],
            'wind' => [
                'speed' => 5.59,
                'deg' => 248,
            ],
            'name' => 'Rajkot',
            // Include other necessary data here
        ]);

        $response = new Response(200, [], $responseBody);

        $weatherUrl = 'https://api.openweathermap.org/data/2.5/weather';
        $weatherKey = config('services.open_weather_map_key');
        // Set up the expected API request
        $httpClientMock->expects($this->once())
            ->method('request')
            ->with('GET', $weatherUrl, [
                'query' => [
                    'q' => 'Rajkot',
                    'appid' => $weatherKey,
                ],
            ])
            ->willReturn($response);

        // Instantiate your OpenWeatherMapService
        $openWeatherMapService = new OpenWeatherMapService($httpClientMock);

        // Call the method you want to test
        $weatherData = $openWeatherMapService->getWeatherForCity('Rajkot');
        //dd($weatherData);
        // Assert the expected results
        $this->assertIsArray($weatherData);
        $this->assertArrayHasKey('name', $weatherData);

        // Store the weather data in a model
        $city = City::whereName('rajkot')->first();
        $weatherModel = $city->cityWeathers()->create([
            'temperature' => $weatherData['main']['temp'],
            'min_temperature' => $weatherData['main']['temp_min'],
            'max_temperature' => $weatherData['main']['temp_max'],
            'humidity' => $weatherData['main']['humidity'],
            'wind_speed' => $weatherData['wind']['speed'],
        ]);
        // Assert that the model is created with the correct data
        $this->assertInstanceOf(CityWeather::class, $weatherModel);
    }

    public function testGetFiveDayWeatherForecastAndStoreInModel()
    {
        // Mocking the GuzzleHttp\Client
        $httpClientMock = $this->createMock(Client::class);
        $this->app->instance(Client::class, $httpClientMock);

        // Creating a mock response
        $responseBody = file_get_contents(storage_path('app/5day_forecast.json'));

        $response = new Response(200, [], $responseBody);

        $forcastWeatherUrl = 'https://api.openweathermap.org/data/2.5/forecast';
        $weatherKey = config('services.open_weather_map_key');
        // Set up the expected API request
        $httpClientMock->expects($this->once())
            ->method('get')
            ->with($forcastWeatherUrl, [
                'query' => [
                    'q' => 'Rajkot',
                    'appid' => $weatherKey,
                ],
            ])
            ->willReturn($response);

        // Instantiate your WeatherService
        $weatherService = new OpenWeatherMapService($httpClientMock);

        // Call the method you want to test
        $forecastData = $weatherService->getFiveDayWeatherForecast('Rajkot');

        // Assert the expected results
        $this->assertIsArray($forecastData);
        $this->assertArrayHasKey('list', $forecastData);
        // Add more assertions for specific data or structure if needed

        // Store the forecast data in a model
        $city = City::whereName('Rajkot')->first();

        $weatherForecastModel = $city->cityWeathersForcasts()->create([
            'city' => 'Rajkot',
            'forecast_data' => json_encode($forecastData),
        ]);

        $this->assertInstanceOf(WeatherForecast::class, $weatherForecastModel);
        $this->assertEquals('Rajkot', $weatherForecastModel->city);
        $this->assertEquals($forecastData, json_decode($weatherForecastModel->forecast_data, true));
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\OpenWeatherMapService;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

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
            // Include other necessary data here
        ]);

        $response = new Response(200, [], $responseBody);

        $weatherUrl = config('services.open_weather_map_url');
        $weatherKey = config('services.open_weather_map_key');
        // Set up the expected API request
        $httpClientMock->expects($this->once())
            ->method('request')
            ->with('GET', $weatherUrl, [
                'query' => [
                    'q' => 'rajkot',
                    'appid' => $weatherKey,
                ],
            ])
            ->willReturn($response);

        // Instantiate your OpenWeatherMapService
        $openWeatherMapService = new OpenWeatherMapService($httpClientMock);

        // Call the method you want to test
        $weatherData = $openWeatherMapService->getWeatherForCity('rajkot');
        
        // Assert the expected results
        $this->assertEquals('Clear', $weatherData['weather'][0]['main']);
        $this->assertEquals(301.06, $weatherData['main']['temp']);
        $this->assertEquals(301.06, $weatherData['main']['temp_min']);
        $this->assertEquals(301.06, $weatherData['main']['temp_max']);
        $this->assertEquals(1008, $weatherData['main']['pressure']);
        $this->assertEquals(72, $weatherData['main']['humidity']);
        $this->assertEquals(5.59, $weatherData['wind']['speed']);
        $this->assertEquals(248, $weatherData['wind']['deg']);
    }
}

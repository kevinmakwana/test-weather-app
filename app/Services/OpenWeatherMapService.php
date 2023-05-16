<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OpenWeatherMapService
{
    protected $client;
    protected $apiKey;
    protected $weatherUrl;
    protected $weatherForcastUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = config('services.open_weather_map_key');
        $this->weatherUrl = 'https://api.openweathermap.org/data/2.5/weather';
        $this->weatherForcastUrl = 'https://api.openweathermap.org/data/2.5/forecast';
    }

    public function getWeatherForCity($city)
    {
        //dd($this->client,$this->weatherUrl,$this->apiKey);
        try {
            $response = $this->client->request('GET', $this->weatherUrl, [
                'query' => [
                    'q' => $city,
                    'appid' => $this->apiKey,
                ],
            ]);

            $body = $response->getBody();
            
            $data = json_decode($body, true);

            return $data;
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    public function getFiveDayWeatherForecast($city)
    {
        try {
            $response = $this->client->get('https://api.openweathermap.org/data/2.5/forecast', [
                'query' => [
                    'q' => $city,
                    'appid' => $this->apiKey,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
}

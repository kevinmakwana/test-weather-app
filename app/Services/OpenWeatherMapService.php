<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OpenWeatherMapService
{
    protected $client;
    protected $apiKey;
    protected $weatherUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = config('services.open_weather_map_key');
        $this->weatherUrl = config('services.open_weather_map_url');
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
            // Handle the exception appropriately, e.g., log the error or throw a custom exception
            throw $e;
        }
    }
}

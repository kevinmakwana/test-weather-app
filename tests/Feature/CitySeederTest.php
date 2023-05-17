<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\CityWeather;
use Database\Seeders\CityTableSeeder;
use Tests\TestCase;

class CitySeederTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        CityWeather::query()->delete();
        City::query()->delete();
        $this->seed(CityTableSeeder::class);

        $citiesCount = City::count();
        $this->assertEquals(5, $citiesCount); // Adjust the expected count based on your seeded data
    }
}

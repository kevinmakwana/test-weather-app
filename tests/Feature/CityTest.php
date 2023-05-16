<?php

namespace Tests\Feature;

use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CityTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testCreateCity()
    {
        $cityData = [
            'name' => 'New York'
        ];

        $city = City::create($cityData);

        $this->assertInstanceOf(City::class, $city);
        $this->assertDatabaseHas('cities', $cityData);
    }
}

<?php

namespace Tests\Feature;

use App\Models\City;
use Database\Seeders\CityTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CitySeederTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        Artisan::call('migrate:fresh');
        $this->seed(CityTableSeeder::class);

        $citiesCount = City::count();
        $this->assertEquals(5, $citiesCount); // Adjust the expected count based on your seeded data
    }
}

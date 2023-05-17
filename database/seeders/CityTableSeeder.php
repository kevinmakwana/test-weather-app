<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'name' => 'Ahmedabad',
                'latitude' => 72.6167,
                'longitude' => 23.0333,
            ],
            [
                'name' => 'Rajkot',
                'latitude' => 70.7833,
                'longitude' => 22.3,
            ],
            [
                'name' => 'Baroda',
                'latitude' => 78.6195,
                'longitude' => 30.1149,
            ],
            [
                'name' => 'Surat',
                'latitude' => 72.8333,
                'longitude' => 21.1667,
            ],
            [
                'name' => 'Gandhinagar',
                'latitude' => 72.6833,
                'longitude' => 23.2167,
            ],
            // Add more cities as needed
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}

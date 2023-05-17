<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreateCityRequest;
use App\Models\City;

class CityController extends Controller
{
    //
    public function create(StoreCreateCityRequest $request)
    {
        $response = City::create([
            'name' => $request->name,
        ]);

        return response()->json($response, 200);
    }
}

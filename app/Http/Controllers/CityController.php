<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreateCityRequest;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    //
    public function create(StoreCreateCityRequest $request){
        $response = City::create([
            'name' => $request->name
        ]);
        return response()->json($response,200);
    }
}

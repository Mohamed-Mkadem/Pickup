<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CityController extends Controller
{
    public function getCities($stateId)
    {
        // Retrieve the cities based on the selected state
        $cities = City::where('state_id', $stateId)->get();

        // Return the cities as JSON response
        return response()->json($cities);
    }
}

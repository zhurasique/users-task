<?php

namespace App\Services;


use App\Http\Resources\CountryResource;
use App\Models\Country;

class CountryService
{
    public function index()
    {
        return CountryResource::collection(Country::all());
    }
}

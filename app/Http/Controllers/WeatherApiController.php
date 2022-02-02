<?php

namespace App\Http\Controllers;

use App\Extensions\Weather\Weather;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WeatherApiController extends Controller
{
    //Retrieves data for one city
    public function getDataFromApi(string $city)
    {
        $api = env('API_WEATHER');
        $weather = new Weather("https://api.openweathermap.org/data/2.5/weather", $api);

        return $weather->getCityDetails($city);
    }

    //Get the weather forecast from the coordinates of the locality
    public function getForecastData(float $lat, float $lon){

        $api = env('API_WEATHER');
        $weather = new Weather("https://api.openweathermap.org/data/2.5/onecall", $api);

        return $weather->getForecastData($lat, $lon);
    }

    //Checks if there is a city with this name or the city is not in Poland
    public function cityValidation(string $city){
        
        $api = env('API_WEATHER');
        $weather = new Weather("https://api.openweathermap.org/data/2.5/weather", $api);

        return $weather->cityValidation($city);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\WeatherApiController;
use App\Models\City;
use App\Models\WeatherHistory;

class WeatherController extends Controller
{
    //Displays the current weather information for saved cities
    public function index(){

        $cities = City::all();
        $dataAPI = new WeatherApiController();
        $weather = array();
        
        foreach($cities as $city){
            $data = $dataAPI->getDataFromApi($city->name);

            if(!$data){
                continue;
            }

            array_push($weather, json_decode($data));
        }
        
        return view('index', [
            'weather' => $weather
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $city, $country
     * @param float $lat, $lon
     * @return \Illuminate\Http\Response
     */
    public function show($city, $country, $lat, $lon)
    {
        $dataAPI = new WeatherApiController();
        $weatherHistory = WeatherHistory::where('name',$city)->first();

        $data = $dataAPI->getForecastData($lon, $lat);

        return view("weatherDetails", [
            'weather' => $data,
            'city' => $city,
            'country' => $country,
            'weatherHistory' => $weatherHistory
        ]);
    }

    //Get hitory weather data
    public function showHistory(Request $request)
    {
        $weatherHistory = WeatherHistory::where('name',$request->city)
                        ->where('created_at','>',$request->dateFrom." ".$request->timeFrom)
                        ->where('created_at','<',$request->dateTo." ".$request->timeTo)->get();
                        
        return view("weatherHistory", [
            'weather' => $weatherHistory
        ]);
    }
}

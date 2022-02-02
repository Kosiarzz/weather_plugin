<?php

namespace App\Extensions\Weather;

use Illuminate\Support\Facades\Http;

class Weather
{
    protected $url;
    protected $apiKey;

    public function __construct(string $url, string $apiKey)
    {
        $this->url = $url;
        $this->apiKey = $apiKey;
    }

    //Retrieves data for one city
    public function getCityDetails(string $city)
    {
        try
        {
            $response = Http::get($this->url,[
                'q' => $city,
                'lang' => 'pl',
                'units' => 'metric',
                'appid' => $this->apiKey,
            ]);

            return $response->body();
        }catch(\Exception $exception)
        {
            return false;
        }
    }

    //Get the weather forecast from the coordinates of the locality
    public function getForecastData(float $lat, float $lon){

        $response = Http::get($this->url,[
            'lat' => $lat,
            'lon' => $lon,
            'lang' => 'pl',
            'units' => 'metric',
            'exclude' => 'minutely,alerts',
            'appid' => $this->apiKey,
        ]);

        return json_decode($response->getBody());
    }

    //Checks if there is a city with this name or the city is not in Poland
    public function cityValidation(string $city){
        
        try {
            $response = Http::get($this->url,[
                'q' => $city,
                'lang' => 'pl',
                'units' => 'metric',
                'appid' => $this->apiKey,
            ]);

            $data = json_decode($response->getBody());

            if($data->sys->country != "PL"){
                return "Podane miasto nie znajduje się w Polsce!";
            }

            return false;
        } catch (\Exception $exception) {
   
            return "Takie miasto nie istnieje!";
        }
        
    }

}
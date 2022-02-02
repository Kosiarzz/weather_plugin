<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use App\Http\Controllers\WeatherApiController;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings', [
            'cities' => City::where('status', 0)->get(),
            'saveCities' =>  City::where('status', 1)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        $city = new City($request->validated());
        $country = new WeatherApiController();

        $validation = $country->cityValidation($city->name);

        //Checks if there is a city with this name
        if($validation != false)
        {
            return redirect(route('city.settings'))->with('Danger', $validation);
        }

        $city->save();
        
        return redirect(route('city.settings'))->with('Success','Miasto zostało dodane.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $city = City::find($id);
            $city->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Miasto zostało usunięte.'
            ]);
        }catch(Exception $exception){

            return response()->json([
                'status' => 'error',
                'message' => 'Wystąpił błąd podczas usuwania miasta!'
            ])->setStatusCode(500); 
        }
    }

    //The function checks if the maximum number of cities has been reached and changes the status of the city. 
    //Data is save to the database.
    public function saveWeatherData(Request $request){
        
        $cities = City::where('status', 1)->get();

        if(count($cities) > 9){

            return redirect(route('city.settings'))->with('Danger','Nie możesz dodać więcej miast.');
        }

        $city = City::find($request->id);
        $city->status = 1;
        $city->save();

        return redirect(route('city.settings'))->with('Success','Dodano miasto do zapisu.');
    }

    //The function changes the status of the city. Data is not save to the database.
    public function notSaveWeatherData(Request $request){
        
        $city = City::find($request->id);
        $city->status = 0;
        $city->save();

        return redirect(route('city.settings'))->with('Success','Dane nie są już zapisywane dla tego miasta.');
    }
}

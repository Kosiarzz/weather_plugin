<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\WeatherController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/settings',[CityController::class,'index'])->name('city.settings');
Route::post('/settings/city',[CityController::class, 'store'])->name('city.store');
Route::delete('/settings/city/{id}',[CityController::class, 'destroy'])->name('city.destroy');
Route::post('/settings/saveData',[CityController::class, 'saveWeatherData'])->name('city.saveWeatherData');
Route::post('/settings/notSaveData',[CityController::class, 'notSaveWeatherData'])->name('city.notSaveWeatherData');

Route::get('/',[WeatherController::class,'index'])->name('weather.index');
Route::get('/weather/{city}/{country}/{lon}/{lat}',[WeatherController::class,'show'])->name('weather.show');
Route::post('/weather/history',[WeatherController::class,'showHistory'])->name('weather.showHistory');
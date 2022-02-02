<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;
use App\Models\WeatherHistory;
use App\Http\Controllers\WeatherApiController;

class weather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It records the weather of selected cities every 30 minutes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cities = City::where('status', 1)->get();
        $dataAPI = new WeatherApiController();

        $results = [];

        foreach($cities as $city){
            $data = $dataAPI->getDataFromApi($city->name);

            if(!$data){
                continue;
            }

            $results[] = [
                "name" => $city->name,
                "data" => json_encode($data),
                "created_at" => now(),
                "updated_at" => now()
            ];
        }

        return WeatherHistory::insert($results);
    }
}

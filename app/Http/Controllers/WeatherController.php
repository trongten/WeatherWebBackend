<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    { 
        $apiKey = env('WEATHER_API_KEY');
        $apiURL = env('WEATHER_API_URL');
        // Default country is Vietnam
        $country = $request->has('country') ? $request->input('country') : "vietnam";
        $day = $request->has('day') ? $request->input('day') : 6;
        $currentDate = Carbon::now()->format('Y-m-d');
        $infoWeatherString = strtolower('weather-'.$currentDate ."-". $country."-". $day);

        if(Cache::has($infoWeatherString)) {
            // Get the data from the cache
            $data = Cache::get($infoWeatherString);
            return response()->json($data);
        }else{
            // Get the data from the API
            $url = "http://$apiURL?key=$apiKey&q=$country&days=$day&aqi=no&alerts=no";
            $client = new Client();
            
            try {
                $response = $client->get($url);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Could not get weather data']);
            }
            
            // Cache the data for the rest of the day
            $data = json_decode($response->getBody(), true);
            $secondsToEndOfDay = Carbon::now()->diffInSeconds(Carbon::now()->endOfDay());
            Cache::put($infoWeatherString, $data, $secondsToEndOfDay);

            return response()->json($data);
        }
    }
}

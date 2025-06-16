<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        // 東京の緯度経度
        $latitude = 35.6895;
        $longitude = 139.6917;
        $url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&daily=weathercode,temperature_2m_max,temperature_2m_min&timezone=Asia%2FTokyo";

        $response = Http::get($url);
        $weather = $response->json();

        return view('weather', ['weather' => $weather]);
    }
}

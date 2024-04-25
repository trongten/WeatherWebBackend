<?php

use App\Http\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/weather', [WeatherController::class, 'getWeather']);

Route::post('/confirm', [SubscriberController::class, 'sendConfirmCode']);

Route::post('/subscribe', [SubscriberController::class, 'confirmSubscribe']);

Route::post('/unsubscribe', [SubscriberController::class, 'confirmUnsubscribe']);
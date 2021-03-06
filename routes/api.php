<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BusController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BusStopController;
use App\Http\Controllers\API\BusRouteController;
use App\Http\Controllers\API\BusTimingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
  
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);

Route::group([
    'middleware' => ['api','jwt.verify']
 ], function ($router) {
    Route::get('users', [UserController::class, 'index']);
    Route::get('/bus-stops', [BusStopController::class, 'bus_stops']);
    Route::get('/bus-stops/{bus_stop_id}', [BusStopController::class, 'bus_list']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('users', [UserController::class, 'store']);
    Route::resource('users', UserController::class);
    Route::resource('bus', BusController::class);
    Route::resource('busstop', BusStopController::class);
    Route::resource('busroute', BusRouteController::class);
    Route::resource('bustiming', BusTimingController::class);
 });

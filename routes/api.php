<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BusController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
  
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::get('/bus-stops', [BusController::class, 'getNearByBusStop']);
Route::group([
    'middleware' => ['api','jwt.verify']
 ], function ($router) {
    Route::get('/bus-stops', [BusController::class, 'getNearByBusStop']);
    Route::get('/bus-stops/{bus_stop_id}', [BusController::class, 'getBusByBusStopId']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('me', [AuthController::class, 'me']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users', [UserController::class, 'index']);
    Route::resource('users', UserController::class);
    Route::resource('bus', BusController::class);
 });

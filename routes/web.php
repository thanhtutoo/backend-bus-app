<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BusController;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('bus-list', 'API\BusController@bus_list');
Route::get('/buses', [BusController::class, 'bus_list']);
// Route::resource('buses', 'API\BusController');
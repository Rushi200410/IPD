<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\SeeDataController;

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



Route::get('/sensor/latest', [SeeDataController::class, 'showLatest']);

Route::get('/sensor/latest-json', [SeeDataController::class, 'latestJson']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\FakeApiController;
use \App\Http\Controllers\Api\PropertyController;

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

Route::prefix('fake')->controller(FakeApiController::class)->group(function () {

    Route::get('json', 'json');
    Route::get('xml', 'xml');
    Route::get('run', 'run');

});

Route::get('properties', PropertyController::class);

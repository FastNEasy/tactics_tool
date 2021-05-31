<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function () {//midleware izpildaas pirms un peec
    Route::group(['prefix' => 'example-api'], function () {
        // Route::get('do-request', 'SampleController@doEndpoint');
        Route::post('save-sports-type', 'App\Http\Controllers\SportsTypeController@saveSportsType');
        Route::post('save-tactic', 'App\Http\Controllers\TacticsController@saveTactic');
        //pievienot route
    });
    Route::apiResource('users', 'UserController');
    Route::get('users/{user}/permissions', 'UserController@permissions');

});
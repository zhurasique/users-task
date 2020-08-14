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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', 'Api\UserController@index');
Route::post('users', 'Api\UserController@store');
Route::delete('users/{user}', 'Api\UserController@destroy');
Route::put('users/{user}', 'Api\UserController@update');


Route::get('countries', 'Api\CountryController@index');

<?php

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

Route::post('auth/login', 'Api\\AuthController@login');
Route::post('auth/register', 'Api\\AuthController@register');
Route::post('auth/logout', 'Api\\AuthController@logout');


Route::group(['middleware' => 'apiJwt'], function () {
  Route::get('users', 'Api\\UserController@index');
});

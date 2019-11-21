<?php

use Illuminate\Http\Request;

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
Route::namespace('Api\Auth')->prefix('auth')->name('auth.')->group(function () {
    Route::post('register', 'RegisterController@register')->name('register');
    Route::get('register/verify', 'RegisterController@verifyEmail')
            ->name('verify')
            ->middleware(['auth:api', 'check.token']);
            
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
});

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication routes
Route::post('/user/login', 'AuthController@login');
Route::get('/user/logout', 'AuthController@logout');
Route::post('/user/register', 'AuthController@register');

// Stores resource routes
Route::resource('stores', 'StoreController');
// Products resource routes
Route::resource('products', 'ProductController');
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

Route::post('validate-card', 'PublicController@validateCard');
Route::post('authenticate-card', 'PublicController@authenticateCard');
Route::post('check-out', 'PublicController@checkOut');
Route::post('top-up', 'PublicController@topUp');

Route::group(['prefix' => 'admin'], function () {
    Route::post('login', 'AdminController@login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', 'AdminController@logout');

        Route::get('transactions', 'TransactionController@index');
        Route::get('transactions/user/{user}', 'TransactionController@byUser');

        Route::get('products', 'ProductController@index');
        Route::get('products/{product}', 'ProductController@show');
        Route::post('products', 'ProductController@store');
        Route::put('products/{product}', 'ProductController@update');
        Route::delete('products/{product}', 'ProductController@destroy');

        Route::get('vendors', 'VendorController@index');
        Route::get('vendors/{vendor}', 'VendorController@show');
        Route::post('vendors', 'VendorController@store');
        Route::put('vendors/{vendor}', 'VendorController@update');
        Route::delete('vendors/{vendor}', 'VendorController@destroy');

        Route::get('counters', 'CounterController@index');
        Route::get('counters/{counter}', 'CounterController@show');
        Route::post('counters', 'CounterController@store');
        Route::put('counters/{counter}', 'CounterController@update');
        Route::delete('counters/{counter}', 'CounterController@destroy');

        Route::get('users', 'UserController@index');
        Route::get('users/{user}', 'UserController@show');
        Route::post('users', 'UserController@store');
        Route::put('users/{user}', 'UserController@update');
        Route::delete('users/{user}', 'UserController@destroy');
    });
});

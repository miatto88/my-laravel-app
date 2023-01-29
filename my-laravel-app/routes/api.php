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

Route::post('/login', 'Api\ApiAuthController@login');

Route::get('/user', 'Api\ApiUserController@index');
Route::post('/user', 'Api\ApiUserController@store');
Route::get('/user/{id}', 'Api\ApiUserController@show');
Route::patch('/user/{id}', 'Api\ApiUserController@update');
Route::delete('/user/{id}', 'Api\ApiUserController@destroy')->name('api.user.delete');

Route::get('/todo', 'Api\ApiTodoController@index');
Route::post('/todo', 'Api\ApiTodoController@store');
Route::get('/todo/{id}', 'Api\ApiTodoController@show');
Route::patch('/todo/{id}', 'Api\ApiTodoController@update');
Route::delete('/todo/{id}', 'Api\ApiTodoController@destroy')->name('api.todo.delete');
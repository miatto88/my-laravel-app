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

Route::get('/user', 'ApiUserController@index');
Route::get('/user', 'ApiUserController@index');
Route::post('/user', 'ApiUserController@store');
Route::get('/user/{id}', 'ApiUserController@show');
Route::patch('/user/{id}', 'ApiUserController@update');
Route::delete('/user/{id}', 'ApiUserController@destroy')->name('api.user.delete');

Route::get('/todo', 'ApiTodoController@index');
Route::post('/todo', 'ApiTodoController@store');
Route::get('/todo/{id}', 'ApiTodoController@show');
Route::patch('/todo/{id}', 'ApiTodoController@update');
Route::delete('/todo/{id}', 'ApiTodoController@destroy')->name('api.todo.delete');
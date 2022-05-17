<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/index', 'TodoController@index')->name('index');
Route::get('/detail/{id}', 'TodoController@detail')->name('detail');
Route::get('/new', 'TodoController@new')->name('new');
Route::post('/new', 'TodoController@store')->name('store');
Route::get('/edit/{id}', 'TodoController@edit')->name('edit');
Route::post('/edit/{id}', 'TodoController@update')->name('update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

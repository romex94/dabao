<?php

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
	$name = 'I am groot';
    return view('welcome', ['name' => $name]);
});


Route::post('/user','UserController@store');
Route::post('/complain','ComplainController@store');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user','UserController@edit');
Route::post('/user','UserController@update');

Route::post('/order','OrderController@store');

Route::post('/address','AddressController@create');


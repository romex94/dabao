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


Route::post('/complain','ComplainController@store');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/user','UserController@store');
Route::get('/user','UserController@edit');
Route::post('/user','UserController@update');

Route::post('/order','OrderController@store');

Route::post('/address','AddressController@store');
Route::get('/address','AddressController@create');
Route::get('/address/update', 'AddressController@edit');
Route::post('/address/update','AddressController@update');

Route::get('/userform', function () {
    return view('User.user-form');
});

Route::get('/addressform', function () {
    return view('Address.address-form');
});

Route::get('/add-addressform', function () {
    return view('Address.add-address-form');
});


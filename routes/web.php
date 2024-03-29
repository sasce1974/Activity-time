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



Route::get('/', 'TimeSpentController@index');

Route::post('/store', 'TimeSpentController@store');

Route::delete('/delete', 'TimeSpentController@destroy');

Route::fallback(function(){
    return redirect('/');
});
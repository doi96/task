<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('task')->group( function(){
    Route::get('views', 'TaskController@views');
    Route::post('create', 'TaskController@create');
    Route::match(['get','post'],'update/{id}','TaskController@update');
    Route::get('delete/{id}', 'TaskController@delete');
});

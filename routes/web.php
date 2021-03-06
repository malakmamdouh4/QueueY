<?php

use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/showUsers','BusinessController@showUsers');

Route::delete('/deleteUser/{id}','BusinessController@deleteUser')->name('deleteUser');

Route::get('/showAreas','BusinessController@showAreas');

Route::delete('/deleteArea/{id}','BusinessController@deleteArea')->name('deleteArea');

Route::get('showEditAreas/{id}','BusinessController@showEditAreas')->name('showEditAreas');

Route::post('editArea/{id}','BusinessController@editArea')->name('editArea');

Route::get('showAddAreas','BusinessController@showAddAreas');








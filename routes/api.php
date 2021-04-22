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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix'=>'user','middleware'=>'api'],function ()
{
    Route::post('/register','userController@register');                    // to sign up as a user
    Route::post('/login','userController@login');;                         // to login as a user
    Route::get('/profile/{id}','userController@userProfile');          // to get into user profile
    Route::put('/editName/{id}','userController@editName');                // to edit user name
    Route::get('/showPassword/{id}','userController@showPassword');        // to get old password
    Route::put('/editPassword/{id}','userController@editPassword');        // to update new password
    Route::post('/logout','userController@logout');                        // to logout

});


   // to get all destinations that they are in app
Route::get('getAllDestination','ShowController@getAllDestination');

  // to get destination that belongs to a specific user by using user_id
Route::get('getDestination/{id}','ShowController@getDestination');

  // to get all areas that belong to a specific destination by using destination_id
Route::get('getArea/{id}','ShowController@getArea');

  // to get all services that belong to a specific area by using area_id
Route::get('getService/{id}','ShowController@getService');


Route::get('getDate','BookingController@getDate');



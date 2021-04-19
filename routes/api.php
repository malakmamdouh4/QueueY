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








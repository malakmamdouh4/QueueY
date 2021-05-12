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
    Route::get('/profile','userController@userProfile');                   // to get into user profile
    Route::post('upload','userController@upload');                         // upload image profile
    Route::put('/editName','userController@editName');                     // to edit user name
    Route::get('/showPassword','userController@showPassword');             // to get old password
    Route::put('/editPassword','userController@editPassword');             // to update new password
    Route::post('/logout','userController@logout');// to logout
    // to get all destinations that they are in app
    Route::get('getAllDestination','ShowController@getAllDestination');

    // to get destination that belongs to a specific user by using user_id
    Route::get('getDestination/{id}','ShowController@getDestination');

    // to get all areas that belong to a specific destination by using destination_id
    Route::get('getArea','ShowController@getArea');

    // to upload images for every area by using area_id
    Route::post('uploadAreaImage/{id}','ShowController@uploadAreaImage');
    Route::post('uploadDestinationImage/{id}','ShowController@uploadDestinationImage');

    // to get all services that belong to a specific area by using area_id
    Route::get('getService','ShowController@getService');
    Route::post('uploadServicesImage/{id}','ShowController@uploadServicesImage');

    // to get all appointments ( booked or not ) in lab service
    Route::put('getDate','BookingController@getDate');

    Route::post('insertDates','BookingController@insertDates');

    // to get all notification for lab service
    Route::get('getNotification','BookingController@getNotification');

    // to delete appointment in lab service
    Route::post('deleteNotification','BookingController@deleteNotification');

    // to book specific appointment by using id
    Route::put('updateStatus','BookingController@updateStatus');

    // to get all departments in area
    Route::get('getDepartment','BookingController@getDepartment');

    Route::post('uploadDepartmentImage/{id}','BookingController@uploadDepartmentImage');

    // to get all doctors that belong to a specific department by using department_id
    Route::get('getDoctor','BookingController@getDoctor');
    Route::post('uploadDoctorImage/{id}','BookingController@uploadDoctorImage');

    // to retrieve day instead of date
//Route::get('retrieveDay/{id}','BookingController@retrieveDay');

    // to get all available days
    Route::get('getDayMeetings','BookingController@getDayMeetings');

    // to get all times that belongs to a specific day
    Route::get('getTimeMeetings','BookingController@getTimeMeetings');

    // to book meeting
    Route::post('bookMeeting','BookingController@bookMeeting');

    // to contact with affair / send problem
    Route::post('getAffair','BookingController@getAffair');

    // to upload image of option
    Route::post('uploadImageOption/{id}','BookingController@uploadImageOption');

    // to get all options
    Route::get('getOption','BookingController@getOption');

    // to send a problem
    Route::post('sendProblem','BookingController@sendProblem');

    // te send rate
    Route::post('sendRate','BookingController@sendRate');
});










//Route::get('image/{filename}','BookingController@image');

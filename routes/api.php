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


                      //////////               user                    //////////

Route::group(['prefix'=>'user','middleware'=>'api'],function () {


    // to sign up as a user or business
    Route::post('/register', 'userController@register');


    // to login as a user or register
    Route::post('/login', 'userController@login');;


    // to get into user profile
    Route::get('/profile', 'userController@userProfile');


    // to change user_profile image
    Route::post('upload', 'userController@upload');


    // to change user name
    Route::put('/editName', 'userController@editName');


    // to change user password
    Route::put('/editPassword', 'userController@editPassword');


    // to contact with affair / send problem
    Route::post('getAffair', 'userController@getAffair');


    // to send a problem
    Route::post('sendProblem', 'userController@sendProblem');


    // te send rate
    Route::post('sendRate', 'userController@sendRate');


    // to delete appointment/notification in any service
    Route::post('deleteNotification', 'userController@deleteNotification');


    // to logout from profile
    Route::post('/logout', 'userController@logout');

});


                  //////////               business                    //////////

Route::group(['prefix'=>'business','middleware'=>'api'],function () {

    // to get all destinations that they are in app
    Route::get('getAllDestination', 'BusinessController@getAllDestination');


    // to upload images for every destination by using destination_id
    Route::post('uploadDestImage/{id}', 'BusinessController@uploadDestImage');


    // to get all areas that belong to a specific destination by using destination_id
    Route::get('getArea', 'BusinessController@getArea');


    // to upload images for every area by using area_id
    Route::post('uploadAreaImage/{id}', 'BusinessController@uploadAreaImage');


    // to get all services that belong to a specific area by using area_id
    Route::get('getService', 'BusinessController@getService');


    // to upload images for every service by using service_id
    Route::post('uploadServicesImage/{id}', 'BusinessController@uploadServicesImage');


    // to get all options
    Route::get('getOption', 'BusinessController@getOption');


    // to upload image for every option bu using option_id
    Route::post('uploadImageOption/{id}', 'BusinessController@uploadImageOption');


    // to get all notification/appointment
    Route::get('getNotification', 'BusinessController@getNotification');

});

                      //////////                service                    //////////

Route::group(['prefix'=>'service','middleware'=>'api'],function () {

                            //**          lab service            **//

    // to get all appointments ( booked or not ) in lab service
    Route::put('getDate', 'LabController@getDate');


    // to book specific appointment in lab service by using id
    Route::put('updateStatus', 'LabController@updateStatus');


                           //**          meeting service            **//

    // to get all departments in area
    Route::get('getDepartment', 'MeetingController@getDepartment');


    // to upload image for every department by using department_id
    Route::post('uploadDeptImage/{id}', 'MeetingController@uploadDeptImage');


    // to get all doctors that belong to a specific department by using department_id
    Route::get('getDoctor', 'MeetingController@getDoctor');


    // to upload image for every doctor by using doctor_id
    Route::post('uploadDoctorImage/{id}', 'MeetingController@uploadDoctorImage');


    // to get all available days
    Route::get('getDayMeetings', 'MeetingController@getDayMeetings');


    // to get all times that belongs to a specific day
    Route::get('getTimeMeetings', 'MeetingController@getTimeMeetings');


    // to book meeting
    Route::post('bookMeeting', 'MeetingController@bookMeeting');
});


                      //////////               admin                    //////////

Route::group(['prefix'=>'admin','middleware'=>'api'],function () {

    // to get old password
    Route::get('/showPassword','AdminController@showPassword');


    // to get destination that belongs to a specific user by using user_id
    Route::get('getDestination/{id}','AdminController@getDestination');


    // to insert data by using carbon
    Route::post('insertDates','AdminController@insertDates');


    // to add am or pm to time in lab service
    Route::post('timePeriod','AdminController@timePeriod');


    // to retrieve day instead of date
    Route::get('retrieveDay/{id}','BookingController@retrieveDay');


});










//Route::get('image/{filename}','BookingController@image');

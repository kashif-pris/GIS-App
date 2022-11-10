<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController_1;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
// */
Route::post('check-out', 'LocationController_1@checking');
// Route::get('check-out', 'LocationController@checking');





Route::group(['namespace' => 'Api\V1'], function () {

  
  
    Route::group(['prefix' => 'user', 'namespace' => 'Auth'], function () {
        Route::get('send-notification-to', 'LocationController_1@checkOneSginal_1'); 
        Route::post('dataEntryTest', 'LocationController_1@dataEntryTest'); 
        Route::post('check-out', 'LocationController_1@checking');
        Route::post('checkInAttendance', 'LocationController_1@checkInAttendance'); 
        Route::post('checkOutAttendance', 'LocationController_1@checkOutAttendance'); 

        Route::get('testEntryget', 'LocationController_1@testEntryget'); 
    
    });
    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
        Route::post('login', 'LoginController@login');
        Route::post('check-email', 'CustomerAuthController@check_email');
        Route::post('verify-email', 'CustomerAuthController@verify_email');
        Route::post('forgot-password', 'PasswordResetController@reset_password_request');
        Route::post('verify-token', 'PasswordResetController@verify_token');
        Route::put('reset-password', 'PasswordResetController@reset_password_submit');
    });
    Route::group(['prefix' => 'user', 'namespace' => 'Auth','middleware'=>['auth:api']], function () {
    
        Route::get('profile', 'LoginController@get_profile');
        Route::post('update-profile', 'LoginController@settings_update');
        // Route::post('check-out', 'LocationController_1@checking');
        // Route::get('check-out', 'LocationController_1@checking');
        Route::post('post-leave-request', 'AdminController@storeLeave');  //get-all-notifications
        Route::get('get-all-notifications', 'LocationController_1@notifications');
        Route::get('setups', 'AdminController@setups');


    });

});

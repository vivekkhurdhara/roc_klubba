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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('/employee', 'EmployeeController');
    // Route::apiResource('/friendship', 'FriendshipController')->middleware('auth:api');
    Route::post('/user_profile', 'UserProfileController@userProfileStore');
    Route::post('/user-detail', 'UserProfileController@userDetail');
    Route::post('/user-about-update', 'UserProfileController@userAboutUpdate');
    Route::post('/user-update', 'UserProfileController@updateUserProfile');
});

Route::post('/countries', 'UserController@countries');
Route::post('/states', 'UserController@states');
Route::post('/cities', 'UserController@cities');
Route::post('/checkEmail', 'UserController@checkEmail');
Route::post('/intrests', 'UserController@intrests');
Route::post('/designations', 'UserController@designations');
Route::post('/professional_objectives', 'UserController@professional_objectives');
Route::post('/industries', 'UserController@industries');
Route::post('/functional_areas', 'UserController@functional_areas');
Route::post('/skills', 'UserController@skills');


Route::post('/register', 'Auth\UserAuthController@register');
Route::post('/login', 'Auth\UserAuthController@login')->name('login');



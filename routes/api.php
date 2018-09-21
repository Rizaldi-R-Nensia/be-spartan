<?php

use Illuminate\Http\Request;

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

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('open', 'DataController@open');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');
    Route::get('logout', 'UserController@logout');
    Route::get('sdm', 'Sdm\SdmController@list');
});

Route::group(['prefix' => 'sdm'], function () {
    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('religion/list', 'Sdm\ReligionController@list');
        Route::get('religion/detail/{religion_id}', 'Sdm\ReligionController@detail');
        Route::post('religion/insert', 'Sdm\ReligionController@insert');
        Route::put('religion/update/{religion_id}', 'Sdm\ReligionController@update');
        Route::delete('religion/delete/{religion_id}','Sdm\ReligionController@delete');
    });
});
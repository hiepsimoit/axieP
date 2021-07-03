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


Route::group(['middleware'=>'auth:web'],function (){
    Route::get('earn/{link}', 'earnedController@getSLPearnedPerDay');
    Route::get('getSlpEndOfDay', 'earnedController@getSlpEndOfDay');

    Route::get('userInfo', 'InvertorController@userInfo');
    Route::post('userInfo', 'InvertorController@editUserInfo');
    Route::get('logout1', 'InvertorController@logout');
    Route::get('changePass', 'InvertorController@changePass');
    Route::post('changePass', 'InvertorController@postChangePass');

    Route::group(['prefix'=>'staff'],function (){
        Route::get('/','StaffController@index');
        Route::post('/','StaffController@index');
        Route::get('add','StaffController@add');
        Route::post('add','StaffController@postAdd');
        Route::get('edit/{id}','StaffController@edit');
        Route::get('delete/{id}','StaffController@delete');
        Route::post('edit/{id}','StaffController@postEdit');
    });

    Route::group(['prefix'=>'account'],function (){
        Route::get('/','AccountController@index');
        Route::post('/','AccountController@index');
        Route::get('add','AccountController@add');
        Route::post('add','AccountController@postAdd');
        Route::get('edit/{id}','AccountController@edit');
        Route::get('delete/{id}','AccountController@delete');
        Route::post('edit/{id}','AccountController@postEdit');
    });
});
Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();


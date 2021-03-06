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

Route::get('admin/login', 'Auth\LoginController@showAdminLoginForm');
Route::post('admin/login', 'Auth\LoginController@adminLogin');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', 'AdminController@index');

    Route::get('investor', 'AdminInvestorController@index');
    Route::post('investor', 'AdminInvestorController@index');
    Route::get('investor/delete/{id}', 'AdminInvestorController@delete');
    Route::get('investor/active/{id}', 'AdminInvestorController@active');
    Route::get('investor/deletePaid/{id}', 'AdminInvestorController@deletePaid');
    Route::get('investor/activePaid/{id}', 'AdminInvestorController@activePaid');
    //   Route::post('investor/delete/{id}','AccountController@postEdit');


    Route::get('buy_package', 'AdminBuyPackageController@index');
    Route::post('buy_package', 'AdminBuyPackageController@index');
    Route::get('buy_package/delete/{id}', 'AdminBuyPackageController@delete');
    Route::get('buy_package/active/{id}', 'AdminBuyPackageController@active');

    Route::get('changePass', 'AdminUserController@change');
    Route::post('changePass', 'AdminUserController@postChangePass');
    Route::get('logout', 'AdminUserController@adminLogout');
});


Route::group(['middleware' => 'auth:web'], function () {
    Route::get('earnedPerDay', 'earnedController@getSLPearnedPerDay');
    Route::get('getSlpEndOfDay', 'earnedController@getSlpEndOfDay');

    Route::get('accsInfo', 'AccountController@showAccountsInfo');

    Route::get('userInfo', 'InvertorController@userInfo');
    Route::post('userInfo', 'InvertorController@editUserInfo');
    Route::get('logout1', 'InvertorController@logout');
    Route::get('changePass', 'InvertorController@changePass');
    Route::post('changePass', 'InvertorController@postChangePass');

    Route::group(['prefix' => 'staff'], function () {
        Route::get('/', 'StaffController@index');
        Route::post('/', 'StaffController@index');
        Route::get('add', 'StaffController@add');
        Route::post('add', 'StaffController@postAdd');
        Route::get('edit/{id}', 'StaffController@edit');
        Route::get('delete/{id}', 'StaffController@delete');
        Route::post('edit/{id}', 'StaffController@postEdit');
        Route::get('active/{id}', 'StaffController@active');
    });

    Route::group(['prefix' => 'account'], function () {
        Route::get('/', 'AccountController@index');
        Route::post('/', 'AccountController@index');
        Route::get('add', 'AccountController@add');
        Route::post('add', 'AccountController@postAdd');
        Route::get('edit/{id}', 'AccountController@edit');
        Route::get('delete/{id}', 'AccountController@delete');
        Route::post('edit/{id}', 'AccountController@postEdit');
    });
    Route::group(['prefix' => 'buy_package'], function () {
        Route::get('/', 'BuyPackageController@index');
        Route::post('/', 'BuyPackageController@index');
        Route::get('add', 'BuyPackageController@add');
        Route::post('add', 'BuyPackageController@postAdd');
        Route::get('edit/{id}', 'BuyPackageController@edit');
        Route::get('delete/{id}', 'BuyPackageController@delete');

        Route::post('edit/{id}', 'BuyPackageController@postEdit');
    });
    Route::post('getTotalBuyPackage', 'BuyPackageController@getTotalBuyPackage');
});
Route::get('/', 'Auth\LoginController@showLoginForm');
Auth::routes();

Route::get('register/confirm/{id}', 'InvertorController@confirm');
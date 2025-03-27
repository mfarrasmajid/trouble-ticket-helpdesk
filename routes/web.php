<?php

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

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@submit_login');
Route::get('/logout', 'AuthController@logout')->name('logout');
Route::get('/', 'MainController@portal')->name('portal');
Route::prefix('dwh')->group(function () {
    Route::get('/dashboard', 'DWHController@dashboard_dwh')->name('dashboard_dwh');
});
Route::prefix('admin')->group(function () {
    Route::get('/dashboard_admin', 'AdminController@dashboard_admin')->name('dashboard_admin');
    Route::get('/manage_users', 'AdminController@manage_users')->name('manage_users');
    Route::get('/detail_users/{id?}', 'AdminController@detail_users')->name('detail_users');
    Route::post('/detail_users/{id?}', 'AdminController@submit_users');
    Route::get('/manage_airflow_table', 'AdminController@manage_airflow_table')->name('manage_airflow_table');
    Route::get('/detail_airflow_table/{id?}', 'AdminController@detail_airflow_table')->name('detail_airflow_table');
    Route::post('/detail_airflow_table/{id?}', 'AdminController@submit_airflow_table');
});
Route::prefix('api')->group(function() {
    Route::prefix('admin')->group(function(){
        Route::post('/delete_users/{id}', 'AdminController@delete_users')->name('delete_users');
        Route::get('/get_list_manage_users', 'AdminController@get_list_manage_users')->name('get_list_manage_users');
        Route::post('/delete_airflow_table/{id}', 'AdminController@delete_airflow_table')->name('delete_airflow_table');
        Route::get('/get_list_manage_airflow_table', 'AdminController@get_list_manage_airflow_table')->name('get_list_manage_airflow_table');
    });
});

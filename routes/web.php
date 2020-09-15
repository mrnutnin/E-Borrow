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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//Admin
Route::get('/manage-goods', 'Admin\GoodAdminController@index')->name('manage-goods.index');
Route::post('/manage-goods/show-goods', 'Admin\GoodAdminController@showGood')->name('manage-goods.show');
Route::post('/manage-goods/store', 'Admin\GoodAdminController@storeGood')->name('manage-goods.store');
Route::post('/manage-goods/delete', 'Admin\GoodAdminController@deleteGood')->name('manage-goods.delete');

Route::get('/manage-materials', 'Admin\MaterialAdminController@index')->name('manage-materials.index');
Route::post('/manage-materials/show-materials', 'Admin\MaterialAdminController@showMaterials')->name('manage-materials.show');
Route::post('/manage-materials/store', 'Admin\MaterialAdminController@storeMaterial')->name('manage-materials.store');
Route::post('/manage-materials/delete', 'Admin\MaterialAdminController@deleteMaterial')->name('manage-materials.delete');
Route::post('/manage-materials/add-amount', 'Admin\MaterialAdminController@addAmount')->name('manage-materials.add-amount');
Route::post('/manage-materials/add-bill', 'Admin\MaterialAdminController@addAmount')->name('manage-materials.add-bill');
Route::post('/manage-materials/show-histories', 'Admin\MaterialAdminController@showHistory')->name('manage-materials.show.history');
Route::get('/manage-materials/history', 'Admin\MaterialAdminController@history')->name('manage-materials.history');
Route::get('/manage-materials/approve', 'Admin\MaterialAdminController@approve')->name('manage-materials.approve');
Route::post('/manage-materials/approve-borrow', 'Admin\MaterialAdminController@approveBorrow')->name('manage-materials.approve-borrow');

//User
Route::get('/materials/borrow', 'User\MaterialUserController@index')->name('materials.index');
Route::post('/materials/show-materials', 'User\MaterialUserController@showMaterials')->name('materials.show');
Route::post('/materials/order', 'User\MaterialUserController@orderMaterial')->name('materials.order');
Route::get('/materials/history', 'User\MaterialUserController@history')->name('materials.history');
Route::post('/materials/show-histories', 'User\MaterialUserController@showHistory')->name('materials.show.history');

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

Route::get('logout', 'Auth\LoginController@logout', function () {
    return abort(404);
});

Auth::routes();

Route::get('/loginSSO', 'Auth\LoginSSOController@loginSSO')->name('loginSSO');
Route::get('/login-sso', 'Auth\LoginSSOController@getLogin');
Route::get('/logout-sso', 'Auth\LoginSSOController@getLogout');
//Route for normal user
Route::group(['middleware' => ['user']], function () {
    // Route::get('/home', 'HomeController@index');
    Route::get('/home', 'User\UserController@index')->name('user');

    //Materials
    Route::get('/materials/borrow', 'User\MaterialUserController@index')->name('materials.index');
    Route::post('/materials/show-materials', 'User\MaterialUserController@showMaterials')->name('materials.show');
    Route::post('/materials/order', 'User\MaterialUserController@orderMaterial')->name('materials.order');
    Route::get('/materials/history', 'User\MaterialUserController@history')->name('materials.history');
    Route::post('/materials/show-histories', 'User\MaterialUserController@showHistory')->name('materials.show.history');
    //Goods
    Route::get('/goods/borrow', 'User\GoodUserController@index')->name('goods.index');
    Route::post('/goods/show-goods', 'User\GoodUserController@showGoods')->name('goods.show');
    Route::post('/goods/order', 'User\GoodUserController@orderGood')->name('goods.order');
    Route::get('/goods/history', 'User\GoodUserController@history')->name('goods.history');
    Route::post('/goods/show-histories', 'User\GoodUserController@showHistory')->name('goods.show.history');


});

//Route for admin
Route::group(['middleware' => ['admin']], function(){
    // Route::get('/dashboard', 'admin\AdminController@index');
    Route::get('/admin', 'Admin\AdminController@index')->name('admin');


    Route::post('/countGoodApprove', 'Admin\AdminController@countGoodApprove');
    Route::post('/countMatApprove', 'Admin\AdminController@countMatApprove');
    // Route::get('/home', 'Admin\AdminController@index')->name('admin');

    Route::get('/manage-goods', 'Admin\GoodAdminController@index')->name('manage-goods.index');
    Route::post('/manage-goods/show-goods', 'Admin\GoodAdminController@showGood')->name('manage-goods.show');
    Route::post('/manage-goods/store', 'Admin\GoodAdminController@storeGood')->name('manage-goods.store');
    Route::post('/manage-goods/delete', 'Admin\GoodAdminController@deleteGood')->name('manage-goods.delete');
    Route::post('/manage-goods/add-amount', 'Admin\GoodAdminController@addAmount')->name('manage-goods.add-amount');
    Route::post('/manage-goods/show-histories', 'Admin\GoodAdminController@showHistory')->name('manage-goods.show.history');
    Route::get('/manage-goods/history', 'Admin\GoodAdminController@history')->name('manage-goods.history');
    Route::get('/manage-goods/approve', 'Admin\GoodAdminController@approve')->name('manage-goods.approve');
    Route::post('/manage-goods/approve-borrow', 'Admin\GoodAdminController@approveBorrow')->name('manage-goods.approve-borrow');

    //Materials
    Route::get('/manage-materials', 'Admin\MaterialAdminController@index')->name('manage-materials.index');
    Route::post('/manage-materials/show-materials', 'Admin\MaterialAdminController@showMaterials')->name('manage-materials.show');
    Route::post('/manage-materials/store', 'Admin\MaterialAdminController@storeMaterial')->name('manage-materials.store');
    Route::post('/manage-materials/delete', 'Admin\MaterialAdminController@deleteMaterial')->name('manage-materials.delete');
    Route::post('/manage-materials/add-amount', 'Admin\MaterialAdminController@addAmount')->name('manage-materials.add-amount');
    Route::post('/manage-materials/show-histories', 'Admin\MaterialAdminController@showHistory')->name('manage-materials.show.history');
    Route::get('/manage-materials/history', 'Admin\MaterialAdminController@history')->name('manage-materials.history');
    Route::get('/manage-materials/approve', 'Admin\MaterialAdminController@approve')->name('manage-materials.approve');
    Route::post('/manage-materials/approve-borrow', 'Admin\MaterialAdminController@approveBorrow')->name('manage-materials.approve-borrow');

    //Generals
    //Unit
    Route::get('/generals/manage-units', 'Admin\GeneralController@indexUnit')->name('generals.manage-units.index');
    Route::post('/generals/manage-units/show', 'Admin\GeneralController@showUnits')->name('generals.manage-units.show');
    Route::post('/generals/manage-units/store', 'Admin\GeneralController@storeUnit')->name('generals.manage-units.store');
    Route::post('/generals/manage-units/delete', 'Admin\GeneralController@deleteUnit')->name('generals.manage-units.delete');

    //Type
    Route::get('/generals/manage-types', 'Admin\GeneralController@indexType')->name('generals.manage-types.index');
    Route::post('/generals/manage-types/show', 'Admin\GeneralController@showTypes')->name('generals.manage-types.show');
    Route::post('/generals/manage-types/store', 'Admin\GeneralController@storeType')->name('generals.manage-types.store');
    Route::post('/generals/manage-types/delete', 'Admin\GeneralController@deleteType')->name('generals.manage-types.delete');

    //Department
    Route::get('/generals/manage-departments', 'Admin\GeneralController@indexDepartment')->name('generals.manage-departments.index');
    Route::post('/generals/manage-departments/show', 'Admin\GeneralController@showDepartments')->name('generals.manage-departments.show');
    Route::post('/generals/manage-departments/store', 'Admin\GeneralController@storeDepartment')->name('generals.manage-departments.store');
    Route::post('/generals/manage-departments/delete', 'Admin\GeneralController@deleteDepartment')->name('generals.manage-departments.delete');


    //Report
    Route::get('/report', 'Admin\ReportController@index')->name('reports.index');
    Route::get('/report/good', 'Admin\ReportController@indexGood')->name('reports.goods.index');
    Route::get('/report/material', 'Admin\ReportController@indexMaterial')->name('reports.mats.index');
    Route::get('/report/show-good-report', 'Admin\ReportController@showGoodReport')->name('reports.goods.show');
    Route::post('/report/export-good-excel', 'Admin\ReportController@exportGoodExcel')->name('reports.goods.export');
    Route::get('/report/show-good-report2', 'Admin\ReportController@showGoodReport2')->name('reports.goods.show2');
    Route::post('/report/export-good-excel2', 'Admin\ReportController@exportGoodExcel2')->name('reports.goods.export2');
    // Route::get('/report/show-good-pdf', 'Admin\ReportController@exportGoodPDF')->name('reports.goods.pdf.export');


    Route::get('/report/show-mat-report', 'Admin\ReportController@showMatReport')->name('reports.mats.show');
    Route::post('/report/export-mat-excel', 'Admin\ReportController@exportMatExcel')->name('reports.mats.export');
    Route::get('/report/show-mat-report2', 'Admin\ReportController@showMatReport2')->name('reports.mats.show2');
    Route::post('/report/export-mat-excel2', 'Admin\ReportController@exportMatExcel2')->name('reports.mats.export2');
    // Route::get('/report/show-mat-pdf', 'Admin\ReportController@exportMatPDF')->name('reports.mats.pdf.export');


});

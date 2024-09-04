<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
// Route::get('/admin/cases/getProducts', [CaseController::class, 'getProducts']);

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('cases', 'Backend\CasesController', ['names' => 'admin.case']);
    Route::get('cases/getList/{id}', 'Backend\CasesController@getItem')->name('admin.case.item');
    Route::get('cases/getcase/{id}', 'Backend\CasesController@getCase')->name('admin.case.getCase');
    Route::get('cases/importExportView/{id}', 'Backend\CasesController@importExportView')->name('admin.case.import.view');
    Route::get('cases/export', 'Backend\CasesController@export')->name('admin.case.export');
    Route::post('cases/import', 'Backend\CasesController@import')->name('admin.case.import');
    Route::get('cases/reinitatiate-case/{id}', 'Backend\CasesController@reinitatiateCaseNew')->name('admin.case.reinitatiateCaseNew');
    Route::post('cases/reinitatiate-case/store', 'Backend\CasesController@reinitatiateNew')->name('admin.case.reinitatiate.store');
    Route::get('cases/upload-image/{id}', 'Backend\CasesController@uploadCaseImage')->name('admin.case.upload.image');
    Route::post('cases/upload-image/{id}', 'Backend\CasesController@uploadImage')->name('admin.case.upload.image');
    Route::post('cases/delete-image/{id}', 'Backend\CasesController@deleteImage')->name('admin.case.delete.image');

    Route::post('cases/assignAgent', 'Backend\CasesController@assignAgent')->name('admin.case.assignAgent');
    Route::post('cases/resolveCase', 'Backend\CasesController@resolveCase')->name('admin.case.resolveCase');
    Route::post('cases/verifiedCase', 'Backend\CasesController@verifiedCase')->name('admin.case.verifiedCase');
    Route::post('cases/updateConsolidated', 'Backend\CasesController@updateConsolidated')->name('admin.case.updateConsolidated');
    Route::get('cases/caseClose/{id}', 'Backend\CasesController@closeCase')->name('admin.case.close');
    Route::get('cases/clone/{id}', 'Backend\CasesController@cloneCase')->name('admin.case.clone');
    Route::get('cases/case-status/{status}/{user_id?}', 'Backend\CasesController@caseStatus')->name('admin.case.caseStatus');
    Route::get('cases/view/{id}', 'Backend\CasesController@viewCaseByCftId')->name('admin.case.viewCase');
    Route::get('cases/update/{id}', 'Backend\CasesController@viewCaseByCftId')->name('admin.case.updateCase');
    Route::get('cases/getdetail/{id}', 'Backend\CasesController@viewCase')->name('admin.case.viewCase');
    Route::get('cases/{id}/editCase', 'Backend\CasesController@editCase')->name('admin.case.editCase');
    Route::post('cases/update-case/{id}', 'Backend\CasesController@modifyCase')->name('admin.case.modifyCase');
    Route::get('cases/view-form/{id}', 'Backend\CasesController@getForm')->name('admin.case.viewForm');
    Route::get('cases/view-form-edit/{id}', 'Backend\CasesController@modifyForm')->name('admin.case.viewForm.modify');
    // Route::post('cases/update-view-form-case/{id}', 'Backend\CasesController@modifyRVCase')->name('admin.case.modifyCase.viewCase');
    Route::post('cases/update-bv-form-case/{id}', 'Backend\CasesController@modifyBVCase')->name('admin.case.modifyBVCase');
    Route::post('cases/update-rv-form-case/{id}', 'Backend\CasesController@modifyRVCase')->name('admin.case.modifyRVCase');
    Route::get('cases/zip-download/{id}', 'Backend\CasesController@zipDownload')->name('admin.case.zip.download');



    Route::get('cases/assigned/{status}/{user_id?}', 'Backend\CasesController@assigned')->name('admin.case.assigned');
    Route::get('cases/detail/{id}', 'Backend\CasesController@viewCaseAssign')->name('admin.case.viewCaseAssign');

    Route::resource('reports', 'Backend\RolesController', ['names' => 'admin.reports']);
    Route::resource('fitypes', 'Backend\FITypesController', ['names' => 'admin.fitypes']);
    Route::resource('products', 'Backend\ProductsController', ['names' => 'admin.products']);
    Route::resource('banks', 'Backend\BanksController', ['names' => 'admin.banks']);
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::get('users/agent/{id}', 'Backend\UsersController@getAgent')->name('admin.users.agent');
    Route::get('users/status/{type}/{parent_id?}', 'Backend\UsersController@getCaseStatus')->name('admin.users.caseStatus');

    // Route::get('users/agent/{id}', 'Backend\UsersController@getAgent')->name('admin.users.agent');
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);

    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
});

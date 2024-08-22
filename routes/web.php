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
    Route::resource('cases', 'Backend\CasesController', ['names' => 'admin.cases']);
    Route::get('cases/getList/{id}', 'Backend\CasesController@getItem')->name('admin.case.item');
    Route::get('cases/importExportView/{id}', 'Backend\CasesController@importExportView')->name('admin.case.import.view');
    Route::get('cases/export', 'Backend\CasesController@export')->name('admin.case.export');
    Route::post('cases/import', 'Backend\CasesController@import')->name('admin.case.import');
    Route::post('cases/assignAgent', 'Backend\CasesController@assignAgent')->name('admin.cases.assignAgent');
    Route::post('cases/resolveCase', 'Backend\CasesController@resolveCase')->name('admin.cases.resolveCase');
    Route::post('cases/verifiedCase', 'Backend\CasesController@verifiedCase')->name('admin.cases.verifiedCase');
    Route::get('cases/case-status/{status}/{user_id?}', 'Backend\CasesController@caseStatus')->name('admin.cases.caseStatus');
    Route::get('cases/view/{id}', 'Backend\CasesController@viewCaseByCftId')->name('admin.cases.viewCase');
    Route::get('cases/{id}/edit', 'Backend\CasesController@editCase')->name('admin.cases.editCase');
    Route::get('cases/update/{id}', 'Backend\CasesController@viewCaseByCftId')->name('admin.cases.updateCase');
    Route::get('cases/assigned/{status}/{user_id?}', 'Backend\CasesController@assigned')->name('admin.case.assigned');
    Route::get('cases/getdetail/{id}', 'Backend\CasesController@viewCase')->name('admin.case.viewCase');
    Route::get('cases/detail/{id}', 'Backend\CasesController@viewCaseAssign')->name('admin.case.viewCaseAssign');

    Route::resource('reports', 'Backend\RolesController', ['names' => 'admin.reports']);
    Route::resource('fitypes', 'Backend\FITypesController', ['names' => 'admin.fitypes']);
    Route::resource('products', 'Backend\ProductsController', ['names' => 'admin.products']);
    Route::resource('banks', 'Backend\BanksController', ['names' => 'admin.banks']);
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::get('users/agent/{id}', 'Backend\UsersController@getAgent')->name('admin.users.agent');
    Route::get('users/status/{id}', 'Backend\UsersController@getCaseStatus')->name('admin.users.subStatus');

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

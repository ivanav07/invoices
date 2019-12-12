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

Auth::routes();
Route::get('logout', function ()
{
    Auth::logout();
    return redirect('/');
});
Route::get('/', 'Auth\LoginController@showLoginForm');

//admin routes
Route::group(['middleware' => ['admin']], function ()
{
    Route::get('admin', 'ActivityController@index')->name('dashboard');
    Route::get('admin/{activity_id}/decline', 'ActivityController@decline')->name('activity.decline');
    Route::get('admin/{activity_id}/accept', 'ActivityController@accept')->name('activity.accept');
    Route::get('admin/projects', 'ProjectController@index')->name('admin-projects');
    Route::post('admin/projects', 'ProjectController@create')->name('project.store');
    Route::get('admin/project/{id}', 'ProjectController@show')->name('project');
    Route::put('admin/project/{id}', 'ProjectController@update')->name('project.update');
    Route::get('admin/project-delete/{id}', 'ProjectController@destroy')->name('project.destroy');
    Route::post('admin/project/{id}/add-employees', 'ProjectController@addEmpoyees')->name('project.add.employees');
    Route::get('admin/project/{project_id}/remove/{employee_id}', 'ProjectController@removeEmpoyee')->name('project.remove.employee');
    Route::put('admin/project/{project_id}/update/{employee_id}', 'ProjectController@updateEmpoyee')->name('project.update.employee');
    Route::get('admin/employees', 'UserController@index')->name('employees');
    Route::get('admin/employee/{id}', 'UserController@show')->name('employee');
    Route::put('admin/employee/{id}', 'UserController@update')->name('employee.update');
    Route::get('admin/invoices-unpaid', 'InvoiceController@unpaidInvoices')->name('unpaid-invoices');
    Route::get('admin/invoices-paid', 'InvoiceController@paidInvoices')->name('paid-invoices');
    Route::get('pay-invoice/{id}', 'InvoiceController@pay')->name('pay');
});

//employees' routes
Route::group(['middleware' => ['employee']], function ()
{
    Route::get('/home', 'ActivityController@activities')->name('home');
    Route::post('activity', 'ActivityController@create')->name('activity.store');
    Route::put('activity/{id}', 'ActivityController@update')->name('activity.update');
    Route::get('activity-delete/{id}', 'ActivityController@destroy')->name('activity.destroy');
    Route::get('projects', 'ProjectController@myProjects')->name('projects');
    Route::get('invoices', 'InvoiceController@index')->name('invoices');
    Route::post('invoice', 'InvoiceController@create')->name('invoice.create');
});


Route::get('invoice/{id}', 'InvoiceController@show')->name('invoice')->middleware('invoice');
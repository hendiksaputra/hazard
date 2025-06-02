<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\HazardResponseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'index'])->name('index');
Route::post('/store', [RegisterController::class, 'store'])->name('store');


Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){    
    Route::match(['get', 'post'], 'login', 'AdminController@login');   
    Route::group(['middleware' =>['admin']], function(){
        Route::get('dashboard', 'AdminController@dashboard');
        Route::match(['get', 'post'], 'update-password', 'AdminController@updatePassword');
        Route::match(['get', 'post'], 'update-details', 'AdminController@updateDetails');
        Route::post('check-current-password', 'AdminController@checkCurrentPassword');
        Route::get('logout', 'AdminController@logout');

        // Cms Pages
        Route::get('cms-pages', 'CmsPageController@index');
        Route::post('update-cms-status', 'CmsPageController@update');
        Route::match(['get', 'post'], 'add-edit-cms-page/{id?}', 'CmsPageController@edit');
        Route::get('delete-cms-page/{id?}', 'CmsPageController@destroy');

        // Subadmins
        Route::get('subadmins', 'AdminController@subadmins');
        Route::post('update-subadmin-status', 'AdminController@updateSubadminStatus');
        Route::match(['get', 'post'], 'add-edit-subadmin/{id?}', 'AdminController@addEditSubadmin');
        Route::get('delete-subadmin/{id?}', 'AdminController@deleteSubadmin');
        Route::match(['get', 'post'], 'update-role/{id}', 'AdminController@updateRole');


        // Danger Type
        Route::get('danger-types', 'DangerTypeController@index');
        Route::post('update-danger-status', 'DangerTypeController@d');
        Route::match(['get', 'post'], 'add-edit-danger-type/{id?}', 'DangerTypeController@edit');
        Route::get('delete-danger-type/{id?}', 'DangerTypeController@destroy');

        // Departments
        Route::get('departments', 'DepartmentController@index');
        Route::post('update-department-status', 'DepartmentController@d');
        Route::match(['get', 'post'], 'add-edit-department/{id?}', 'DepartmentController@edit');
        Route::get('delete-department/{id?}', 'DepartmentController@destroy');

        // Position
        Route::get('positions', 'PositionController@index');
        Route::post('update-position-status', 'PositionController@d');
        Route::match(['get', 'post'], 'add-edit-position/{id?}', 'PositionController@edit');
        Route::get('delete-position/{id?}', 'PositionController@destroy');


        //Hazard Report
        Route::get('hazard-reports', 'HazardReportController@index');
        Route::post('update-hazard-status', 'HazardReportController@d');
        Route::get('hazard-create', 'HazardReportController@create');
        Route::post('hazard-store', 'HazardReportController@store');
        Route::get('edit-hazard/{id}','HazardReportController@edit');
        Route::post('hazard-update/{id}','HazardReportController@update');
        Route::get('delete-hazard-reports/{id?}', 'HazardReportController@destroy');
        Route::get('hazard-closed-index', 'HazardReportController@closed_index');
        Route::get('hazard-closed-data', 'HazardReportController@closed_data');
        Route::get('hazard-show-closed/{id}', 'HazardReportController@show_closed');
        Route::get('hazard-report-show/{id}', 'HazardReportController@show');
        Route::post('hazard-report-closed/{id}', 'HazardReportController@close_report');
        Route::post('hazard-rpt-store-attachment', 'HazardReportController@store_attachment');
        Route::post('hazard-rpt-store-response', 'HazardReportController@store_response');
        Route::post('hazard-rpt-delete-response', 'HazardReportController@destroy');

        //Report Attachment
        Route::get('delete-report-attachment/{id?}', 'ReportAttachmentController@destroy');

        //Hazard Response
        Route::get('delete-response/{id?}', 'HazardResponseController@destroy');
        
    });  
});
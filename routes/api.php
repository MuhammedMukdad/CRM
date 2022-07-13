<?php

use App\Http\Controllers\CampaignSourceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\testController;
use App\Http\Controllers\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {

    //Employee
    Route::resource('employees', '\App\Http\Controllers\EmployeeController')->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::get('employees-search', 'EmployeeController@employeeSearch');

    //Services
    Route::resource('employees.services', '\App\Http\Controllers\EmployeeServiceController')->only([
        'index'
    ]);

    //Notifications
    Route::resource('employees_notifications', '\App\Http\Controllers\EmployeeNotificationController')->only([
        'index', 'store', 'show'
    ]);
    Route::resource('employees_received-notifications', '\App\Http\Controllers\EmployeeReceivedNotificationController')->only([
        'index', 'show'
    ]);


    //Services
    Route::resource('services', '\App\Http\Controllers\ServiceController')->only([
        'index', 'store', 'update', 'destroy'
    ]);

    Route::resource('services.employees', '\App\Http\Controllers\ServiceEmployeeController')->only([
        'index'
    ]);

    Route::resource('services.campaigns', '\App\Http\Controllers\ServiceCampaignController')->only([
        'index'
    ]);

    Route::get('services-search', 'CampaignController@compaignSearch');

    //department
    Route::resource('departments.employees', '\App\Http\Controllers\DepartmentEmployeeController')->only([
        'index', 'store'
    ]);


    //campaign
    Route::resource('campaigns.sources', '\App\Http\Controllers\CampaignSourceController')->only([
        'index'
    ]);
    Route::resource('campaigns', '\App\Http\Controllers\CampaignController')->only([
        'show', 'index', 'store', 'update', 'destroy'
    ]);

    Route::get('campaigns-search', 'ServiceController@serviceSearch');


    //Leads
    Route::resource('leads', '\App\Http\Controllers\LeadController')->only([
        'show', 'index', 'store', 'update', 'destroy'
    ]);

    Route::get('leads-search', 'LeadController@leadSearch');

    //sources
    Route::resource('sources.campaigns', '\App\Http\Controllers\SourceCampaignController')->only([
        'index'
    ]);
   

});
Route::post('/user_login', [EmployeeController::class, 'login']);
Route::post('/user_register', [EmployeeController::class, 'register']);

<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/*
Employee
*/
Route::resource('employees', EmployeeController::class)->only([
    'index', 'store', 'update', 'destroy'
]);

Route::resource('employees.services', EmployeeServiceController::class)->only([
    'index'
]);
Route::resource('employees.notifications', EmployeeNotificationController::class)->only([
    'index','store','show'
]);
Route::resource('employees.received-notifications', EmployeeReceivedNotificationController::class)->only([
    'index','show'
]);


Route::get('employees-search','EmployeeController@employeeSearch');

/*
Services
*/

Route::resource('services', ServiceController::class)->only([
    'index', 'store', 'update', 'destroy'
]);

Route::resource('services.employees',ServiceEmployeeController::class)->only([
    'index'
]);

Route::resource('services.campaigns',ServiceCampaignController::class)->only([
    'index'
]);

Route::get('services-search','CampaignController@compaignSearch');
Route::get('services-filter','ServiceController@filterService');
/*
department
*/
Route::resource('departments.employees',DepartmentEmployeeController::class)->only([
    'index','store'
]);

/*
campaign
*/
Route::resource('campaigns.sources',CampaignSourceController::class)->only([
    'index'
]);
Route::resource('campaigns',CampaignController::class)->only([
   'show','index', 'store' ,'update', 'destroy'
]);

Route::get('campaigns-search','CompaignController@compaignSearch');
Route::get('campaigns-filter','CompaignController@filterCampaign');

/**
 * Leads
 */

Route::resource('leads',LeadController::class)->only([
    'show','index', 'store' ,'update', 'destroy'
 ]);

 Route::get('leads-search','LeadController@leadSearch');
 Route::get('leads-filter','LeadController@filterLeads');
 /*
sources
*/
Route::resource('sources.campaigns',SourceCampaignController::class)->only([
    'index'
]);

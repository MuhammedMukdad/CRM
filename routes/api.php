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


/*
Services
*/
Route::resource('services.employees',ServiceEmployeeController::class)->only([
    'index'
]);

Route::resource('services.campaigns',ServiceCampaignController::class)->only([
    'index'
]);
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

Route::get('campaign-search','CampaignSourceController@csearch');

/*
sources
*/
Route::resource('sources.campaigns',SourceCampaignController::class)->only([
    'index'
]);
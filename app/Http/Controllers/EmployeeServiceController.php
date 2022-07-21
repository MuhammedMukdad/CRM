<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = auth('sanctum')->user();
        $services=$employee->services;
        return $this->sendResponse($services,'done');
    }
}

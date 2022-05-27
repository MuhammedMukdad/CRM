<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\employeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{
    public function index()
    {
        $employee=Employee::all();
        return $this->sendResponse($employee,'employees returned seccesfully');
    }
    public function store(employeeRequest $request)
    {

    }
}

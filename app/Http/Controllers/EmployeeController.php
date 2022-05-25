<?php

namespace App\Http\Controllers;

use App\Http\Requests\employeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee=Employee::all();



    }
    public function store(employeeRequest $request)
    {
        
    }
}

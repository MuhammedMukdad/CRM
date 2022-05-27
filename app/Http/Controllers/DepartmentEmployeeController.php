<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\DepartmentEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class DepartmentEmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        $employees=$department->employees;
        return $this->sendResponse($employees,'done');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Department $department,DepartmentEmployeeRequest $request)
    {
        $data=$request->all();
        $data['department_id']=$department->id;
        $employee=Employee::create($data);
        return $this->sendResponse($employee,'done');
    }
}

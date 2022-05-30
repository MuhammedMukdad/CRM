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

    public function employeeSearch(Request $request)
    {
        if($request->search_value!=null){
           $result=$this->search(new Employee(),['name','email','phone','description'],$request->search_value);
            return $this->sendResponse($result,'done');
        }
    }
}

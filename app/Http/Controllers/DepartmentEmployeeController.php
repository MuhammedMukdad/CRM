<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\DepartmentEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class DepartmentEmployeeController extends BaseController
{

    public function index(Department $department)
    {
        $employees = $department->employees;
        return $this->sendResponse($employees, 'done');
    }


    public function store(Department $department, DepartmentEmployeeRequest $request)
    {
        $employee = auth('sanctum')->user();
        if ($employee->role != Constants::ADMIN_ID) {
            return $this->sendError('you do not have permissions');
        } else {
            $employee = auth('sanctum')->user();
            if ($employee->role != Constants::ADMIN_ID) {
                return $this->sendError('you do not have permissions');
            } else {
                $data = $request->all();
                $data['department_id'] = $department->id;
                $employee = Employee::create($data);
                return $this->sendResponse($employee, 'done');
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Employee;
use App\Models\Service;
use App\Models\ServiceEmployee;

//ServiceEmployeeController
class ServiceEmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Service $service)
    {
        $user = auth('sanctum')->user();
        $employees = $service->employees;
        foreach ($employees as $employee) {
            if ($employee->id != $user->id) {
                return $this->sendError('you do not have permissions');
            } else {
                return $this->sendResponse($employees, 'done');
            }
        }
        // if ($employee->role != Constants::ADMIN_ID) {
        //     return $this->sendError('you do not have permissions');
        // } else {
        // return $this->sendResponse($employees,'done');
    }

    public function store(Service $service, Employee $employee)
    {
        $employee = auth('sanctum')->user();
        if ($employee->role != Constants::ADMIN_ID) {
            return $this->sendError('you do not have permissions');
        } else {
            ServiceEmployee::create([
                'service_id' => $service->id,
                'employee_id' => $employee->id
            ]);

            return $this->sendMessage('done');
        }
    }

    public function customersTransfer(Service $service, Employee $old_employee, Employee $new_employee)
    {
        $employee = auth('sanctum')->user();
        if ($employee->role != Constants::ADMIN_ID) {
            return $this->sendError('you do not have permissions');
        } else {
            $temp = ServiceEmployee::where('service_id', $service->id)
                ->where('employee_id', $old_employee->id)
                ->get()->first();
            $temp->state = 0;
            $temp->save();

            ServiceEmployee::create([
                'service_id' => $service->id,
                'employee_id' => $new_employee->id
            ]);
            return $this->sendMessage('done');
        }
    }
}

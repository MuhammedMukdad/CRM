<?php

namespace App\Http\Controllers;

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
        $employees=$service->employees;
        return $this->sendResponse($employees,'done');
    }

    public function store(Service $service,Employee $employee){
        ServiceEmployee::create([
            'service_id'=>$service->id,
            'employee_id'=>$employee->id
        ]);

        return $this->sendMessage('done');
    }

    public function customersTransfer(Service $service,Employee $old_employee,Employee $new_employee){
        $temp=ServiceEmployee::where('service_id',$service->id)
                                ->where('employee_id',$old_employee->id)
                                ->get()->first();
        $temp->state=0;
        $temp->save();

        ServiceEmployee::create([
            'service_id'=>$service->id,
            'employee_id'=>$new_employee->id
        ]);
         return $this->sendMessage('done');
    }
}

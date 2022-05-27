<?php

namespace App\Http\Controllers ;

use App\Http\Controllers\BaseController;
use App\Http\Requests\EmployeeNotificationRequest;
use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Http\Request;

class EmployeeNotificationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        $notifications=$employee->notifications;
        return $this->sendResponse($notifications,'done');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Employee $employee,EmployeeNotificationRequest $request)
    {
        $notification=$request->all();
        $notification['sender_id']=$employee->id;
        $notification=Notification::create($notification);
        return $this->sendResponse($notification,'done');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee,Notification $notification)
    {
        return $employee->id == $notification->sender_id ? $this->sendResponse($notification,'done') : 
                                                            $this->sendError('you do not have permission');
    }
}
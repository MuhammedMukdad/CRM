<?php

namespace App\Http\Controllers ;

use App\Http\Controllers\BaseController;
use App\Http\Requests\EmployeeNotificationRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Notification;
use App\Models\ReceivedNotification;
use Illuminate\Http\Request;

class EmployeeNotificationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = auth('sanctum')->user();
        $notifications=$employee->notifications;
        return $this->sendResponse($notifications,'done');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeNotificationRequest $request)
    {
        $employee = auth('sanctum')->user();
        $notification=$request->all();
        $notification['sender_id']=$employee->id;
        $notification=Notification::create($notification);

        //specify the receivers 
        $dep=Department::findOrFail($request->department_id);
        $recivers=$dep->employees;
        for ($i=0; $i <$recivers->count($recivers) ; $i++) { 
            ReceivedNotification::create([
                'notification_id'=>$notification->id,
                'receiver_id'=>$recivers[$i]->id
            ]);
        }

        return $this->sendResponse($notification,'done');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        $employee = auth('sanctum')->user();
        return $employee->id == $notification->sender_id ? $this->sendResponse($notification,'done') : 
                                                            $this->sendError('you do not have permission');
    }
}

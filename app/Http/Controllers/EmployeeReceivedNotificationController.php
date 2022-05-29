<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Employee;
use App\Models\ReceivedNotification;
use Illuminate\Http\Request;

class EmployeeReceivedNotificationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        $received_notifications=$employee->receivedNotifications;
        return $this->sendResponse($received_notifications,'done');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee,ReceivedNotification $received_notification)
    {
        return $employee->id == $received_notification->receiver_id 
                                ? $this->sendResponse($received_notification,'done') :
                                  $this->sendError('you do not have permission');
    }
}

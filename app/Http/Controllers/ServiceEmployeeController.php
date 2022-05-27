<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\Service;
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
}

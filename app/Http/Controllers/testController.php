<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Employee;
use Illuminate\Http\Request;

class testController extends BaseController
{
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Employee::class)) {
            abort(403);
        }
        $data=$request->all();
        $employee=Employee::create($data);
    }
}

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
        $varEmployee=Employee::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'password'=>$request->password,
            'isAdmin'=>$request->isAdmin,
            'description'=>$request->description,
            'department_id'=>$request->department_id
        ]);
        return $this->sendResponse($varEmployee,'employee Created seccesfully');
    }

    public function update(employeeRequest $request,$id)
    {
        $varEmployee=Employee::find($id);

        $varEmployee->name=$request->name;
        $varEmployee->email=$request->email;
        $varEmployee->phone=$request->phone;
        $varEmployee->address=$request->address;
        $varEmployee->password=$request->password;
        $varEmployee->isAdmin=$request->isAdmin;
        $varEmployee->description=$request->description;
        $varEmployee->department_id=$request->department_id;

        $varEmployee->save();

        return $this->sendResponse($varEmployee,'employee Updated seccesfully');

    }

    public function destroy($id)
    {
        $varEmployee=Employee::find($id);
        
        $varEmployee->delete();
        return $this->sendResponse($varEmployee,'employee deleted seccesfully');

    }

    public function employeeSearch(Request $request)
    {
        if($request->search_value!=null){
           $result=$this->search(new Employee(),['name','email','phone','description'],$request->search_value);
            return $this->sendResponse($result,'done');
        }
    }
}

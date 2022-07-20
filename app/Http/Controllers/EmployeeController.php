<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\employeeRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends BaseController
{
    public function index()
    {
        $employee = Employee::all();
        return $this->sendResponse($employee, 'employees returned seccesfully');
    }
    public function store(employeeRequest $request)
    {
        $employee = auth('sanctum')->user();
        if ($employee->role != Constants::ADMIN_ID) {
            return $this->sendError('you do not have permissions');
        } else {
            $request['password'] = Hash::make($request->password);
            $varEmployee = Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => $request->password,
                'isAdmin' => $request->isAdmin,
                'role' => $request->role,
                'description' => $request->description,
                'department_id' => $request->department_id
            ]);
            $varEmployee->save();

            // $token = $varEmployee->createToken('auth_token')->plainTextToken;
            // return response()->json([
            //     'user' => $varEmployee,
            //     'access_token' => $token,
            // ]);
            return $this->sendResponse($varEmployee, 'employee Created seccesfully');
        }
    }
    // public function register(employeeRequest $request)
    // {
    //     // $employee = auth('sanctum')->user();
    //     // return $employee;
    //     // if ($employee->role != Constants::ADMIN_ID) {
    //     //     return $this->sendError('you do not have permissions');
    //     // } else {
    //         $request['password'] = Hash::make($request->password);
    //         $varEmployee = Employee::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'phone' => $request->phone,
    //             'address' => $request->address,
    //             'password' => $request->password,
    //             'isAdmin' => $request->isAdmin,
    //             'role' => $request->role,
    //             'description' => $request->description,
    //             'department_id' => $request->department_id
    //         ]);
    //         $varEmployee->save();

    //         $token = $varEmployee->createToken('auth_token')->plainTextToken;
    //         return response()->json([
    //             'user' => $varEmployee,
    //             'access_token' => $token,
    //         ]);
    //         // return $this->sendResponse($varEmployee, 'employee Created seccesfully');
    //     // }
    // }
    public function login(LoginRequest $request)
    {

        $employee = Employee::where('email', $request['email'])->first();

        if (!$employee || !Hash::make($request->password) == $employee->password) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }


        $token = $employee->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => $employee,
            'access_token' => $token,
        ]);
    }

    public function update(employeeRequest $request, $id)
    {
        $employee = auth('sanctum')->user();
        if ($employee->role != Constants::ADMIN_ID) {
            return $this->sendError('you do not have permissions');
        } else {
            $varEmployee = Employee::find($id);

            $varEmployee->name = $request->name;
            $varEmployee->email = $request->email;
            $varEmployee->phone = $request->phone;
            $varEmployee->address = $request->address;
            $varEmployee->password = $request->password;
            $varEmployee->isAdmin = $request->isAdmin;
            $varEmployee->description = $request->description;
            $varEmployee->department_id = $request->department_id;

            $varEmployee->save();

            return $this->sendResponse($varEmployee, 'employee Updated seccesfully');
        }
    }

    public function destroy($id)
    {
        $employee = auth('sanctum')->user();
        if ($employee->role != Constants::ADMIN_ID) {
            return $this->sendError('you do not have permissions');
        } else {
            $varEmployee = Employee::find($id);

            $varEmployee->delete();
            return $this->sendResponse($varEmployee, 'employee deleted seccesfully');
        }
    }

    public function employeeSearch(Request $request)
    {
        if ($request->search_value != null) {
            $result = $this->search(new Employee(), ['name', 'email', 'phone', 'description'], $request->search_value);
            return $this->sendResponse($result, 'done');
        }
    }
}

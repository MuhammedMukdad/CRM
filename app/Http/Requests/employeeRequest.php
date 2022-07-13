<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class employeeRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return  [
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'password'=>'required',
            'isAdmin'=>'required',
            'description'=>'required',
            'department_id'=>'required',
            'role'=>'required'
        ];

    }
   
}

<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        
        return [
            'name'=>'required',
            'Creation_date'=>'Creation_date|Date',
            'description'=>'description'
        ];
    }
    // public function messages()
    // {
    //     return [
    //         'name.required' => ' name is required',
    //         'Creation_date.required' => ' Creation_date is required',
    //         'description.required' => ' description is required',
    //     ];
    // }
}

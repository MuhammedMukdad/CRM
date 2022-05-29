<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|string|max:20',
            'email'=>'required|email',
            'phone'=>'required|integer',
            'profit_amount'=>'required',
            'state'=>'required',
            'address'=>'required',
            'arrive_date'=>'required|date',
            'description'=>'required|string|min:0|max:1000',
            'service_id'=>'required|integer',
            'source_id'=>'required|integer',
            'campaign_id'=>'required|integer'
        ];
    }
}

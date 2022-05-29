<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator ;

class CampaignRequest extends FormRequest
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
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',//
            'state'=>'required',
            'num_leads'=>'required|integer',
            'remaining_lead'=>'required|integer',
            'service_id'=>'required|integer',
            'description'=>'required|string|min:0|max:1000',
            
        ];
    }


}

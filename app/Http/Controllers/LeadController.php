<?php

namespace App\Http\Controllers;


use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\LeadRequest;
use Illuminate\Http\Request;
use App\Models\Lead;

class LeadController extends BaseController
{
    public function index()
    {
       $Leads = Lead::all();
       return $this->sendResponse($Leads,'Leads returned successfully');

    }

    public function update(LeadRequest $request,$id){
        $Lead = Lead::findOrFail($id);
        $Lead->name = $request->name;
        $Lead->email = $request->email;
        $Lead->phone = $request->phone;
        $Lead->profit_amount = $request->profit_amount;
        $Lead->state = $request->state;
        $Lead->address = $request->address;
        $Lead->arrive_date = $request->arrive_date;
        $Lead->description = $request->description;
        $Lead->save();

        return $this->sendResponse($Lead,'Lead updated successfully');

   }
    
}

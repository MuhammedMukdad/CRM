<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\CampaignRequest;
use App\Models\Campaign;
use App\Models\Service;

class CampaignController extends BaseController
{


   

    public function index()
    {
       $Campaigns = Campaign::all();
       return $this->sendResponse($Campaigns,'Campaigns returned successfully');
       
    }

    public function store(CampaignRequest $request)
    {
   
       $validated = $request->validated();
       $validated = $request->safe()->all();

       $Campaign= Campaign::create($request->all());

       return $this->sendResponse($Campaign,'Campaign created successfully');

    }

    public function update(CampaignRequest $request,$id){
         $Campaign = Campaign::findOrFail($id);
         $Campaign->name = $request->name;
         $Campaign->start_date = $request->start_date;
         $Campaign->end_date = $request->end_date;
         $Campaign->state = $request->state;
         $Campaign->num_leads = $request->num_leads;
         $Campaign->remaining_lead = $request->remaining_lead;
         $Campaign->description = $request->description;
         $Campaign->save();

         return $this->sendResponse($Campaign,'Campaign updated successfully');
    }


    public function destroy($id){

        $Campaign = Campaign::destroy($id);

        return $this->sendResponse($Campaign,'Campaign destroyed successfully');

    } 
 
   



}

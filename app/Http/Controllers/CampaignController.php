<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\CampaignRequest;
use App\Models\Campaign;
use App\Models\Service;
use App\Models\Source;
use App\Models\SourceCampaign;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CampaignController extends BaseController
{
    public function show($id)
    {

       $Campaign = Campaign::findOrFail($id);
       $Campaign['service_id'] =$Campaign->service->name;
       return $this->sendResponse($Campaign,'Campaigns returned successfully');
       

    }
    public function index()
    {
        $Campaigns = Campaign::all();
        return $this->sendResponse($Campaigns, 'Campaigns returned successfully');
    }

    public function store(CampaignRequest $request)
    {
        $employee = auth('sanctum')->user();
        if ($employee->role == Constants::SALES_EMPLOYEE_ID) {
            return $this->sendError('you do not have permissions');
        } else {
            $validated = $request->validated();
            $validated = $request->safe()->all();

            $Campaign = Campaign::create($request->all());

            return $this->sendResponse($Campaign, 'Campaign created successfully');
        }
    }

    public function update(CampaignRequest $request, $id)
    {
        $employee = auth('sanctum')->user();
        if ($employee->role == Constants::SALES_EMPLOYEE_ID) {
            return $this->sendError('you do not have permissions');
        } else {
            $Campaign = Campaign::findOrFail($id);
            $Campaign->name = $request->name;
            $Campaign->start_date = $request->start_date;
            $Campaign->end_date = $request->end_date;
            $Campaign->state = $request->state;
            $Campaign->num_leads = $request->num_leads;
            $Campaign->remaining_lead = $request->remaining_lead;
            $Campaign->description = $request->description;
            $Campaign->save();

            return $this->sendResponse($Campaign, 'Campaign updated successfully');
        }
    }

    public function filterCampaign(Request $request){
        $collection=new Collection() ;
        $collection=Campaign::all();
        foreach (request()->query() as $query => $value) {
            if(isset($query,$value)){
                if($query == 'service'){
                    $service=Service::where('name',$value)->get()->first();
                    $collection=$collection->where('service_id',$service->id);
                    continue;
                }
                else if($query == 'source'){
                    $source=Source::where('name',$value)->get()->first();
                    $sourceCampaign=SourceCampaign::where('source_id',$source->id);
                    for ($i=0; $i <count($collection) ; $i++) {
                       if(!$sourceCampaign->contains($collection[$i]->id)){
                            $collection->forget($collection[$i]->id);
                       }
                    } 
                    continue;
                }
               else if($query=='start_date1'){
                         $collection=$collection->whereBetween('start_date',[$request->start_date1,$request->start_date2]);
                     }
              else if($query=='end_date1'){
                    $collection=$collection->whereBetween('end_date',[$request->end_date1,$request->end_date2]);
                   }     
                $collection=$collection->where($query,$value);
            }
        }
        return $this->sendResponse($collection,'done');
     }


    public function destroy($id)
    {
        $employee = auth('sanctum')->user();
        if ($employee->role == Constants::SALES_EMPLOYEE_ID) {
            return $this->sendError('you do not have permissions');
        } else {
            $Campaign = Campaign::destroy($id);

            return $this->sendResponse($Campaign, 'Campaign destroyed successfully');
        }
    }


    public function compaignSearch(Request $request)
    {
        if ($request->search_value != null) {
            $result = $this->search(new Campaign(), ['name', 'description'], $request->search_value);
            return $this->sendResponse($result, 'done');
        }
    }
}

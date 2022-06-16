<?php

namespace App\Http\Controllers;


use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\LeadRequest;
use App\Models\Campaign;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Service;
use App\Models\ServiceEmployee;
use App\Models\Source;
use Illuminate\Database\Eloquent\Collection;

class LeadController extends BaseController
{


   public function show($id)
   {
      $Lead = Lead::findOrFail($id);
      return $this->sendResponse($Lead,'Lead returned successfully');

   }
    public function index()
    {
       $Leads = Lead::all();
       return $this->sendResponse($Leads,'Leads returned successfully');

    }

    public function store(LeadRequest $request)
    {
   
       $validated = $request->validated();
       $validated = $request->safe()->all();
      
       $serviceEmp=ServiceEmployee::where('service_id',$request->service_id)->where('state',1)->get();
      $leads=null;
       for ($i=0; $i <count($serviceEmp) ; $i++) { 
         $leads[$i]=Lead::where('employee_id',$serviceEmp[$i]->employee_id)->get();
      }
      $min=100000000000;
      $emp_id=-5;
      for ($i=0; $i <count($leads) ; $i++) { 
         if(count($leads[$i])<$min){
            $min=count($leads[$i]);
            $emp_id=$leads[$i]->employee_id;
         }
      }
      $newLead=$request->all();
      $newLead['employee_id']=$emp_id;
      $newLead['seen']=1;
       $Lead= Lead::create($newLead);

       return $this->sendResponse($Lead,'Lead created successfully');

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

   public function destroy($id){

      $Lead = Lead::destroy($id);
      return $this->sendResponse($Lead,'Lead destroyed successfully');

  } 
   public function leadSearch(Request $request)
    {
        if($request->search_value!=null){
           $result=$this->search(new Lead(),['name','email','phone','description'],$request->search_value);
            return $this->sendResponse($result,'done');
        }
    }

    public function filterLeads(Request $request){
      
        $collection=new Collection() ;
        $collection=Lead::all();
        foreach (request()->query() as $query => $value) {
            if(isset($query,$value)){
                if($query == 'service'){
                    $service=Service::where('name',$value)->get()->first();
                    $collection=$collection->where('service_id',$service->id);
                    continue;
                }
                else if($query == 'campaign'){
                    $campaign=Campaign::where('name',$value)->get()->first();
                    $collection=$collection->where('campaign_id',$campaign->id);
                    continue;
                }
                else if($query == 'source'){
                    $source=Source::where('name',$value)->get()->first();
                    $collection=$collection->where('source_id',$source->id);
                    continue;
                }

                else if($query == 'employee'){
                  $employee=Employee::where('name',$value)->get()->first();
                  $collection=$collection->where('employee_id',$employee->id);
                  continue;
              }
              if($query =='arrive_date'){
               $collection=$collection->whereBetween('arrive_date',[$request->date1,$request->date2]);
                }

                $collection=$collection->where($query,$value);
            }
        }
        return $this->sendResponse($collection,'done');
    }
    
}

<?php

namespace App\Http\Controllers;


use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\LeadRequest;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Exports\LeadExport;
use App\Imports\LeadsImport;
use Excel;
use Illuminate\Support\Facades\DB;
class LeadController extends BaseController
{


   public function show($id)
   {
      $Lead = Lead::findOrFail($id);
      $Lead->service;
      $Lead->source;
      $Lead->campaign;
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

       $Lead= Lead::create($request->all());

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
       $result = $this->filter(new Lead());
       if($request->has('arrive_date')){
         $request=$request->whereBetween('arrive_date',[$request->date1,$request->date2]);
       }
       
       $result->splice($result->count(),0);
       return $this->sendResponse($result,'done');
    }

    public function exportoExcel(Request $request){
   
     return Excel::download(new LeadExport($request) ,'lead1.xlsx' );
    }

    public function exportocsv(){
      return Excel::download(new LeadExport,'lead.csv' );
        }

    public function importLeads(Request $request)
        {
         Excel::import(new LeadsImport, $request->file('file'));
         return 'dd';
        }
    
}

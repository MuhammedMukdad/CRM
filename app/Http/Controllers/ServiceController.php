<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;



class ServiceController extends BaseController
{
    public function index()
    {
        $Service=Service::all();
        return $this->sendResponse($Service,'Services returned seccesfully');
    }
    public function store(Request $request)
    {
        // $varService = $request->validated();
        // $varService = $request->safe()->only(['name', 'Creation_date','description']);
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'Creation_date'=>'Creation_date|Date',
            'description'=>'description'
        ]);
        $varService=Service::create([
            'name'=>$request->input('name'),
            'Creation_date'=>$request->input('Creation_date'),
            'description'=>$request->input('description'),
            
        ]);
        return $this->sendResponse($varService,'Service Created seccesfully');
    }

    public function update(Request $request,$id)
    {
        $varService=Service::find($id);
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'Creation_date'=>'Creation_date|Date',
            'description'=>'description'
        ]);
        $varService->name=$request->name;
        $varService->Creation_date=$request->Creation_date;
        $varService->description=$request->description;
     

        $varService->save();

        return $this->sendResponse($varService,'service Updated seccesfully');

    }

    public function destroy($id)
    {
        $varService=Service::find($id);

        $varService->delete();
        return $this->sendResponse($varService,'service deleted seccesfully');
    }
    public function serviceSearch(Request $request)
    {
        if($request->search_value!=null){
           $result=$this->search(new Service(),['name','description'],$request->search_value);
            return $this->sendResponse($result,'done');
        }
    }

    public function filterService(Request $request){
       // $result = $this->filter(new Service());
        if($request->has('date1')){
          $result=$request->whereBetween('date',[$request->date1,$request->date2]);
        }
        
        $result->splice($result->count(),0);
        return $this->sendResponse($result,'done');
     }
}
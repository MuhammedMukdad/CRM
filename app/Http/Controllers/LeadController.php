<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\LeadRequest;
use App\Models\Campaign;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Lead;

use App\Exports\LeadExport;
use App\Imports\LeadsImport;
use App\Models\ServiceEmployee;
use Excel;
use Illuminate\Support\Facades\DB;

class LeadController extends BaseController
{


   public function show($id)
   {
      $employee = auth('sanctum')->user();
      if ($employee->role == Constants::SALES_EMPLOYEE_ID) { //if user salesEmployee
         $Lead = Lead::where('id', $id)->where('employee_id', $employee->id)->first();
         $Lead->service;
         $Lead->source;
         $Lead->campaign;
         return $this->sendResponse($Lead, 'Lead returned successfully');
      } else {  //if user is Admin and AdEmployee
         $Lead = Lead::findOrFail($id);
         $Lead->service;
         $Lead->source;
         $Lead->campaign;
         return $this->sendResponse($Lead, 'Lead returned successfully');
      }
   }
   public function index()
   {
      $employee = auth('sanctum')->user();
      if ($employee->role == Constants::SALES_EMPLOYEE_ID) { //if user salesEmployee
         $Leads = Lead::where('employee_id', $employee->id)->get();
         $Leads = Lead::all();
         return $this->sendResponse($Leads, 'Leads returned successfully');
      } else {
         $Leads = Lead::all();
         return $this->sendResponse($Leads, 'Leads returned successfully');
      }
   }

   public function store(LeadRequest $request)
   {
      $employee = auth('sanctum')->user();
      if ($employee->role != Constants::ADMIN_ID) {
         return $this->sendError('you do not have permissions');
      } else {

         $validated = $request->validated();
         $validated = $request->safe()->all();

         $serviceEmp = ServiceEmployee::where('service_id', $request->service_id)->where('state', 1)->get();
         $leads = null;
         for ($i = 0; $i < count($serviceEmp); $i++) {
            $leads[$i] = Lead::where('employee_id', $serviceEmp[$i]->employee_id)->get();
         }
         $min = 100000000000;
         $emp_id = -5;
         for ($i = 0; $i < count($leads); $i++) {
            if (count($leads[$i]) < $min) {
               $min = count($leads[$i]);
               $emp_id = $leads[$i]->employee_id;
            }
         }
         $newLead = $request->all();
         $newLead['employee_id'] = $emp_id;
         $newLead['seen'] = 1;
         $Lead = Lead::create($newLead);

         return $this->sendResponse($Lead, 'Lead created successfully');
      }
   }

   public function update(LeadRequest $request, $id)
   {
      $employee = auth('sanctum')->user();
      if ($employee->role == Constants::ADMIN_ID) {
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
         return $this->sendResponse($Lead, 'Lead updated successfully');
      } elseif ($employee->role == Constants::SALES_EMPLOYEE_ID) {
         $Lead = Lead::findOrFail($id);
         $Lead->profit_amount = $request->profit_amount;
         $Lead->state = $request->state;
         $Lead->description = $request->description;
         $Lead->save();
         return $this->sendResponse($Lead, 'Lead updated successfully');
      } else {
         return $this->sendError('you do not have permissions');
      }
   }

   public function destroy($id)
   {
      $employee = auth('sanctum')->user();
      if ($employee->role == Constants::SALES_EMPLOYEE_ID) { //if user salesEmployee
         $Lead = Lead::where('id', $id)->where('employee_id', $employee->id)->first();
         $Lead->delete();
         return $this->sendResponse($Lead, 'Lead destroyed successfully');
      } else {
         $Lead = Lead::find($id);
         $Lead->delete();
         return $this->sendResponse($Lead, 'Lead destroyed successfully');
      }
   }
   public function leadSearch(Request $request)
   {
      if ($request->search_value != null) {
         $result = $this->search(new Lead(), ['name', 'email', 'phone', 'description'], $request->search_value);
         return $this->sendResponse($result, 'done');
      }
   }

   public function filterLeads(Request $request)
   {
      $result = $this->filter(new Lead());
      if ($request->has('arrive_date')) {
         $request = $request->whereBetween('arrive_date', [$request->date1, $request->date2]);
      }

      $result->splice($result->count(), 0);
      return $this->sendResponse($result, 'done');
   }

   public function exportoExcel(Request $request)
   {

      return Excel::download(new LeadExport($request), 'lead1.xlsx');
   }

   public function exportocsv()
   {
      return Excel::download(new LeadExport, 'lead.csv');
   }

   public function importLeads(Request $request)
   {
      Excel::import(new LeadsImport, $request->file('file'));
      return 'dd';
   }
}

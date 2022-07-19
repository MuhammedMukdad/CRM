<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
class LeadExport implements FromCollection,WithHeadings
{
   public  $request;
   

    public function __construct($request)
    {
        $this->request = $request;
        
    }
    public function headings():array{
    return [

    'id',
    'name_lead',
    'email',
    'phone',
    'profit amount',
    'state',
    'address',
    'arrive_date',
    'description',
    'services name',
    'sources name',
    'campaign name',
    
    
       
   ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       

$leads = DB::table('leads')
                  ->select('id','name','email','phone','profit_amount','state',
                  'address',DB::raw(' leads.arrive_date as date_arrive'),'description',
                  'service_id','source_id','campaign_id',
                  
                  ) ->where([//'arrive_date',[$this->request->arrive_date1,$this->request->arrive_date2
                   // ['date_arrive','>=',$this->request->arrive_date1],
                    //['date_arrive','<',$this->request->arrive_date2],
                    ['state','=',$this->request->state],
                    ['source_id','=',$this->request->source_id]
                  ])
                
                  ->get()
                  ->toArray();
                   
 
        $output = [];
        foreach ($leads as $record)
        {
            $service_name=DB::table('services')->where('id', $record->service_id)->first();
            $source_name=DB::table('sources')->where('id', $record->source_id)->first();
            $campaign_name=DB::table('campaigns')->where('id', $record->campaign_id)->first();
           
    
          $output[] = [
              $record->id,
              $record->name,
              $record->email,
              $record->phone,
              $record->profit_amount,
              $record->state,
              $record->address,
              $record->date_arrive,
              $record->description,
              $service_name->name ,
              $source_name->name,
              $campaign_name->name,
          ];
        }

        return collect($output);
       
    }
}

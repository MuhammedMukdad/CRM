<?php

namespace App\Imports;

use App\Models\Lead;
use App\Models\Service;
use App\Models\Source;
use App\Models\Campaign;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;

class LeadsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $service=DB::table('services')->where('name', $row[9])->first();
        $source=DB::table('sources')->where('name', $row[10])->first();
        $campaign=DB::table('campaigns')->where('name', $row[11])->first();
       
   
        return new Lead([
           
           
           //'id'=>$row[0],
           'name' => $row[1],
           'email' => $row[2],
           'phone'=> $row[3],
           'profit_amount'=> $row[4],
           'state'=> $row[5],
           'address'=> $row[6],
           'arrive_date'=> $row[7],
           'description'=> $row[8],
           'service_id'=>$service->id,
           'source_id'=>$source->id,
           'campaign_id'=>$campaign->id

        ]);
    }
}

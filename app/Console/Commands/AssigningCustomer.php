<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Models\ServiceEmployee;
use Illuminate\Console\Command;

class AssigningCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assigning:customer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'assigning customer to employee';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $leads=Lead::where('seen',0)->get();
        $l=null;
        foreach($leads as $lead){
            //get all employees who are responsable about the lead service
            $serviceEmp=ServiceEmployee::where('service_id',$lead->service_id)->where('state',1)->get();
        
         for ($i=0; $i <count($serviceEmp) ; $i++) { 
             //get all leads of the employees to calculate the min one
           $l[$i]=Lead::where('employee_id',$serviceEmp[$i]->employee_id)->get();
        }
        $min=100000000000;
        $emp_id=-5;
        for ($i=0; $i <count($leads) ; $i++) { 
           if(count($leads[$i])<$min){
              $min=count($leads[$i]);
              $emp_id=$leads[$i]->employee_id;
           }
        }
        $lead->employee_id=$emp_id;
        $lead->seen=1;
        $lead->save();
    }
        return 0;
    }
}

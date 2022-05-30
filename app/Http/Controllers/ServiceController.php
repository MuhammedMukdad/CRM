<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    public function serviceSearch(Request $request)
    {
        if($request->search_value!=null){
           $result=$this->search(new Service(),['name','description'],$request->search_value);
            return $this->sendResponse($result,'done');
        }
    }
}

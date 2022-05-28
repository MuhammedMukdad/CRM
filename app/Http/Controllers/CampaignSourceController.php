<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CampaignSourceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Campaign $campaign)
    {
        $sources=$campaign->source;
        return $this->sendResponse($sources,'done');
    }

    public function csearch(Request $request)
    {
        if($request->search_value!=null){
           $result=$this->search(new Campaign(),['name','description'],$request->search_value);
            return $this->sendResponse($result,'done');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\Campaign;
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
}

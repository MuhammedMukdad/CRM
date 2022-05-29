<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\Source;
use Illuminate\Http\Request;

class SourceCampaignController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Source $source)
    {
        $campaigns=$source->campaigns;
        return $this->sendResponse($campaigns,'done');
    }

}

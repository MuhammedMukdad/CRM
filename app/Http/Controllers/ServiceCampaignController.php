<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceCampaignController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Service $service)
    {
        $campaign=$service->campaigns;
        return $this->sendResponse($campaign,'done');

    }
}

<?php

namespace App\Http\Controllers\ChannelsApiControllers;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController
{
    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
}
<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;


use App\Http\Controllers\FrontendControllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {
        return view('frontend.guests.index.indexs');
    }


}
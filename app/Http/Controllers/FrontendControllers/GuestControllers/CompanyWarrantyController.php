<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Http\Controllers\FrontendControllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyWarrantyController extends BaseController
{
    //index
    public function index()
    {
        $id = $this->getId();
        $warranty_list = $this->getAllWarranty($id);
        $count = count($warranty_list);
        return view('frontend.guests.company.index',compact('warranty_list','count'));
    }
}

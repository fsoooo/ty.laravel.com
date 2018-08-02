<?php
namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Http\Controllers\FrontendControllers\BaseController;

class QrCodeController extends BaseController{
    public function index()
    {
        return view('frontend.guests.qrCode.index');
    }
}
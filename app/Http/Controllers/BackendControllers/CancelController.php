<?php

namespace App\Http\Controllers\BackendControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CancelWarrantyRecord;

class CancelController extends Controller
{
    //

    public function index($type)
    {
        if($type!='hesitation'&&$type!='out_hesitation')
        {
            return back()->withErrors('非法操作');
        }
        $cancel_list = CancelWarrantyRecord::where('type',config('attribute_status.cancel_type.'.$type))
            ->with('cancel_order')
            ->paginate(config('list_num.backend.cancel'));
        $count = count($cancel_list);
        return view('backend.cancel.CancelList',compact('cancel_list','count','type'));
    }

    public function cancelDetail($id)
    {
        //获取退保详情
        $cancel_detail = CancelWarrantyRecord::where('id',$id)
            ->with('cancel_order')->first();
        if($cancel_detail){
            return view('backend.cancel.CancelDetail',compact('cancel_detail'));
        }else{
            return back()->withErrors('非法操作');
        }

    }
}

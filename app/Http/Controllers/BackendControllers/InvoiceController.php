<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceController extends BaseController{
	public function index()
	{
		$data = DB::table('invoice')
				->join('users','invoice.user_id','=','users.id')
				->select('invoice.*','users.real_name')
				->get();
		$count = count($data);
		$invoice = DB::table('invoice')->simplePaginate(15);
		$user = DB::table('users')
				->where('type','=','company')
				->select('real_name','id')
				->get();
		return view('backend.invoice.index',compact('data','count','invoice','user'));
	}
	
	//新增表单提交
	public function invoiceSubmit()
	{
		$input = $this->request->all();
		$data['name']=$input['name'];
		$data['phone']=$input['phone'];
		$data['address']=$input['address'];
		$data['user_id']=$input['user_id'];
		$data['status']=1;
		$data['type']=$input['type'];
		DB::table('invoice')
			->insert($data);

		return redirect('backend/invoice/index')->with('status','成功录入');
	}
}
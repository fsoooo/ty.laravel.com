<?php
namespace App\Http\Controllers\BackendControllers;

use Illuminate\Support\Facades\DB;

class AuthenticationController extends BaseController{
	public function index($parameter)
	{
		if($parameter == 'all'){
			$res = DB::table('authentication')
					->join('true_firm_info','license_group_id','code')
					->get();
			$handle = 0;
		}elseif($parameter == 'untreated'){
			//未处理
			$res = DB::table('authentication')
					->join('true_firm_info','license_group_id','code')
					->where('status',1)
					->get();
			$handle = 1;
		}else{
			//已处理
			$res = DB::table('authentication')
					->join('true_firm_info','license_group_id','code')
					->where('status','<>',1)
					->get();
			$handle = 0;
		}
//		dd($res);
		$count = count($res);
		return view('backend.authentication.index',compact('count','res','handle'));
	}
	//个人认证
	public function approvePerson()
	{
		$res = DB::table('authentication_person')
				->join('true_user_info','authentication_person.user_id','true_user_info.user_id')
				->where('status','=',1)
				->get();
		$count = count($res);
//		dd($res);
		return view('backend.authentication.approvePerson',compact('res','count'));
	}

	//个人认证处理
	public function dealPerson($id)
	{
		$res = DB::table('authentication_person')
				->where('id',$id)
				->first();
		$count = count($res);
		return view('backend.authentication.dealPerson',compact('res','count','id'));
	}
	//处理个人认证提交
	public function dealPersonSubmit($id)
	{
		$input = $this->request->all();
		DB::table('authentication_person')
			->where('id',$id)
			->update(['status'=>$input['status']]);

		return redirect('backend/authentication/approvePerson')->with('status','处理完成');
	}

	//处理公司认证
	public function deal($id)
	{
		$res = DB::table('authentication')
				->where('id',$id)
				->get();
//		dd($res);
		return view('backend.authentication.deal',compact('res','id'));
	}

	//处理数据提交
	public function submit($id)
	{
		$input = $this->request->all();
		DB::table('authentication')
			->where('id',$id)
			->update(['status'=>$input['status']]);

		return redirect('backend/authentication/index/untreated');
	}
}
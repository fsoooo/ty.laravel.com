<?php
namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Helper\UploadFileHelper;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\OrderPrepareParameter;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as Requests;
use Maatwebsite\Excel\Facades\Excel;

class GroupInsController extends BaseController{
	public function index()
	{
		$res = Product::where('insure_type',2)
                ->where('ty_product_id','>=',0)
				->paginate(config('list_num.frontend.product_list'));
		$count = count($res);
		foreach($res as $v){
			$v['duties'] = json_decode($this->getProductDuties($v['ty_product_id'])->content,true);
		}
//		dd($res);
		return view('frontend.guests.groupIns.lists',compact('res','count'));
	}

	public function groupInsDetail($id)
	{
		$uid = $this->getId();
		$res = User::where('id',$uid)
				->select('type')
				->first();
		if(isset($_COOKIE['user_id'])){
			$result = $res;
		}else{
			$result = '';
		}
		$result = Product::where('ty_product_id',$id)
			->first();
		return view('frontend.guests.groupIns.proinfo',compact('result'));
	}
	
	public function groupInsNotice()
	{
		$identification = '201708228592224';
		$data = $this->productRight($identification);
		return view('frontend.guests.groupIns.covernotes')
				->with('tariff_params',$data['tariff_params'])
				->with('parameter',$data['parameter'])
				->with('product_res',$data['product_res'])
				->with('identification',$identification);
	}
	//团险填写表单显示页
	public function groupInsForm($id)
	{
		$identification = '201708228592224';
		$data = $this->productRight($identification);
//		dd($data);
//		$id = $this->getId();
//		$type = User::where('id',$id)
//				->select('type')
//				->first();
////		dd($type);
//		if($type->type != 'user'){
//			$person = DB::table('users')
//					->join('true_firm_info','id','=','user_id')
//					->where('id',$id)
//					->select('*')
//					->first();
//		}else{
//			$person = DB::table('users')
//					->where('id',$id)
//					->select('*')
//					->first();
////			dd($person);
//		}
		return view('frontend.guests.groupIns.addforms')
				->with('tariff_params',$data['tariff_params'])
				->with('parameter',$data['parameter'])
				->with('product_res',$data['product_res'])
//				->with('person',$person)
//				->with('type',$type)
				->with('identification',$identification);
	}

	//团险信息提交页
	public function groupInsFormSubmit(Requests $request)
	{
//		dd($_POST);
		$input = $request->all();
//		dd($input);
		if(!1){
			$file = $request->file('license');//获取上传的文件
			$up = new UploadFileHelper();
			$real_path = 'upload/frontend/excel/';
			$path = $up->uploadFile($file,$real_path);
			Excel::load($path,function($reader){
				$data[] = $reader->all();
			});
		}
		$identification = '201708228592224';
		$data = $this->productRight($identification);
		return view('frontend.guests.group.confirmform')
				->with('tariff_params',$data['tariff_params'])
				->with('parameter',$data['parameter'])
				->with('product_res',$data['product_res'])
//				->with('person',$person)
//				->with('type',$type)
				->with('identification',$identification);
	}

	//通知告知页右侧栏信息
	public function productRight($identification){
		$prepare = OrderPrepareParameter::where('identification',$identification)
				->first();
		$parameter = json_decode($prepare->parameter,true);
		$product_res = Product::where('ty_product_id',$parameter['ty_product_id'])->first();
		$tariff_params = config('tariff_parameter');
		unset($tariff_params['tariff']);
		$data = [];
		$data['parameter'] = $parameter;
		$data['product_res'] = $product_res;
		$data['tariff_params'] = $tariff_params;
		return $data;
	}
}
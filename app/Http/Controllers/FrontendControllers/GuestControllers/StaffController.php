<?php
namespace App\Http\Controllers\FrontendControllers\GuestControllers;
use App\Helper\UploadFileHelper;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\AddRecoginzee;
use App\Models\ApiInfo;
use App\Models\EditRecoginzee;
use App\Models\Order;
use App\Models\Product;
use App\Models\WarrantyRecognizee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Excel;

class StaffController extends BaseController{
    protected $_request;

    public function __construct()
    {
        $this->_request = new Request();
    }


    public function index($type)
    {
//        dd($type);
        $option_type = 'staff';
        //人员数据
        if($type == 'done'){
            $data = WarrantyRecognizee::where('status','<>',4)
                ->with('order.product')
                ->whereHas('order',function($q){
                    $q->where([
                        ['user_id',Auth::user()->id],
                        ['status',1]
                    ]);
                })->simplePaginate(14);
        }elseif($type == 'add'){
            $data = AddRecoginzee::with('product')
                ->where([
                ['user_id',Auth::user()->id],
                ['status',1]
            ])
                ->simplePaginate(14);
        }else{
            $data = WarrantyRecognizee::whereHas('order',function($q){
                $q->where('user_id',Auth::user()->id);
            })
                ->where('status',4)
                ->simplePaginate(14);
        }
//        dd($data);
        //购买的产品数据
        $products = DB::table('order')
            ->join('product','order.ty_product_id','product.ty_product_id')
            ->where('order.user_id',Auth::user()->id)
            ->groupBy('product.ty_product_id')
            ->select('product.product_name','product.ty_product_id')
            ->get();
        return view('frontend.guests.company.staff.index',compact('option_type','data','products','type'));
    }

    //编辑员工
    public function editStaff(Request $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try{
            $editStaff = new EditRecoginzee();
            $editStaff->user_id = $this->getId();
            $editStaff->name = $input['name'];
            $editStaff->id_type = $input['id_type'];
            $editStaff->date = $input['date'];
            $editStaff->project = $input['product'];
            $editStaff->id_code = $input['id_code'];
            $editStaff->email = $input['email'];
            $editStaff->status = 1;
            $res = $editStaff->save();
            DB::commit();
            if($res){
                return "<script>alert('人员编辑成功');location.href='/staff/index/done';</script>";
            }else{
                return "<script>alert('人员编辑失败,请稍后重试');location.href='/staff/index/done';</script>";
            }
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }
    }
    
    //删除员工
    public function passStaff($id)
    {
        if($_GET['data'] == 'done'){
            //删除已经在保的人员
            $res = WarrantyRecognizee::where('id',$id)->whereHas('order',function($q){
                $q->where('user_id',Auth::user()->id);
            })
                ->update(['warranty_recognizee.status'=>4]);
        }elseif($_GET['data'] == 'add'){
            $res = AddRecoginzee::where([
                ['id',$id].
                ['user_id',Auth::user()->id]
            ])->update(['status'=>4]);
        }
        if($res){
            return ['status'=>200,'msg'=>'删除成功'];
        }else{
            return ['status'=>400,'msg'=>'删除失败'];
        }
    }

    //获取产品下载模板的url
    public function getUrl($id)
    {
        $data = Product::where('ty_product_id',$id)
            ->first();
        $api_info = ApiInfo::where('private_p_code', $data['private_p_code'])->first();
        $url = json_decode($api_info['json'],true)['template_url'];
        return $url;
    }

    //新增员工
    public function newlyStaff(Request $request)
    {
        $file_data=[];
        $input = $request->all();
        $this->validate($request, [
            'product_name' => 'required',
            'date' => 'required',
            'upFile' => 'required',
        ]);
        if(isset($input['upFile'])){
            $b_path = UploadFileHelper::uploadFile($input['upFile'],'upload/frontend/newly_people/');
            Excel::load($b_path, function($reader) use (&$file_data) {
                $file_data []= $reader->all(); //$data[]就是所要的数据
            });
            $file_data = $file_data[0][0];
            foreach($file_data as $k=>$v){
                if($k >= 1){
                    DB::beginTransaction();
                    try{
                        $addRecognizee = new AddRecoginzee();
                        $addRecognizee->user_id = $this->getId();
                        $addRecognizee->name = !empty($v['ty_beibaoren_name'])?$v['ty_beibaoren_name']:' ';
                        $addRecognizee->id_type = '身份证';
                        $addRecognizee->date = $input['date'];
                        $addRecognizee->project = $input['product_name'];
                        $addRecognizee->id_code = !empty($v['ty_beibaoren_id_number'])?floor($v['ty_beibaoren_id_number']):' ';
                        $addRecognizee->occupation = !empty($v['ty_beibaoren_job'])?$v['ty_beibaoren_job']:' ';
                        $addRecognizee->phone = !empty($v['ty_beibaoren_phone'])?floor($v['ty_beibaoren_phone']):' ';
                        $addRecognizee->status = 1;
                        $res = $addRecognizee->save();
                        DB::commit();
                    }catch (Exception $e){
                        DB::rollBack();
                        return "<script>alert('人员录入失败，请稍后再试');history.back();</script>";
                    }
                }
            }
            return "<script>alert('人员录入成功');location.href='/staff/index/done';</script>";

        }else{
            return "<script>alert('请上传人员添加表');history.back();</script>";
        }
    }

    //获取编辑人员的数据
    public function editPerson($id)
    {
        $data = WarrantyRecognizee::where('id',$id)
            ->with('order.product')
            ->first();
//        print_r($data);
        return ['code'=>200,'msg'=>'获取成功','data'=>$data];
    }
}
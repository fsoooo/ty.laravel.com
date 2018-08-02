<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/9/11
 * Time: 19:32
 */
namespace App\Http\Controllers\FrontendControllers\GuestControllers;
use App\Helper\UploadFileHelper;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\AddRecoginzee;
use App\Models\Authentication;
use App\Models\Contacts;
use App\Models\Order;
use App\Models\TrueFirmInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class CpersonalController extends BaseController{
    //企业认证
    public function approveCompany()
    {
        $data = User::where('id',$_COOKIE['user_id'])->with('trueFirmInfo','authentication')->first();
        return view('frontend.guests.mobile.company.certification',compact('data'));
    }
    
    //认证数据提交
    public function approveSubmit(Request $request)
    {
        $input = $request->all();
//        dd($input);
        $oldData = Authentication::where('user_id',$this->getId())->first();
        if(isset($oldData) && $oldData['status'] == 0){
            return "<script>alert('您已经申请过认证了，请耐心等候审核');history.back();</script>";
        }elseif(isset($oldData) && $oldData['status'] == 2){
            return "<script>alert('您已经认证成功，不需要再次认证');history.back();</script>";
        }elseif(isset($oldData) && $oldData['status'] == 1){
            if(!isset($input['id_type']) || $input['id_type'] == 0){
                //三证合一
                $file_path = UploadFileHelper::uploadImage($input['upFile'],'upload/frontend/company_file/');
                DB::beginTransaction();
                try{
                    //添加认证表
                    $authentication = Authentication::where('user_id',$_COOKIE['user_id'])
                        ->update([
                            'name'=>$input['name'],
                            'credit_code'=>$input['credit_code'],
                            'status'=>0,
                        ]);
                    //添加到true_firm_info
                    $true_firm_info = TrueFirmInfo::where('user_id',$_COOKIE['user_id'])
                        ->update([
                            'license_group_id'=>$input['credit_code'],
                            'license_img'=>$file_path,
                        ]);
                    //添加到user表
                    $user_info = User::where('id',$_COOKIE['user_id'])
                        ->update([
                            'name'=>$input['real_name'],
                            'real_name'=>$input['real_name'],
                            'code'=>$input['credit_code']
                        ]);
                    DB::commit();
                    return "<script>alert('更新成功，请耐心等候审核');location.href = '/information';</script>";
                }catch (Exception $e){
                    DB::rollBack();
                    return "<script>alert('数据录入失败，请稍后重试');location.href = '/information';</script>";
                }
            }else{
                //非三证合一
                $file_path = UploadFileHelper::uploadImage($input['upFile'],'upload/frontend/company_file/');
                DB::beginTransaction();
                try{
                    //添加认证表
                    $authentication = Authentication::where('user_id',$_COOKIE['user_id'])
                        ->update([
                            'name'=>$input['name'],
                            'code'=>$input['code'],
                            'license_code'=>$input['license_code'],
                            'tax_code'=>$input['tax_code'],
                            'status'=>0,
                        ]);
                    //添加到true_firm_info
                    $true_firm_info = TrueFirmInfo::where('user_id',$_COOKIE['user_id'])
                        ->update([
                            'license_group_id'=>$input['license_code'],
                            'license_img'=>$file_path,
                        ]);
                    //添加到user表
                    $user_info = User::where('id',$_COOKIE['user_id'])
                        ->update([
                            'name'=>$input['real_name'],
                            'real_name'=>$input['real_name'],
                            'code'=>$input['license_code']
                        ]);
                    DB::commit();
                    return "<script>alert('更新成功，请耐心等候审核');location.href = '/information';</script>";
                }catch (Exception $e){
                    DB::rollBack();
                    return "<script>alert('数据录入失败，请稍后重试');location.href = '/information';</script>";
                }
            }
        }
        if(!isset($input['id_type']) || $input['id_type'] == 0){
            //三证合一
            $file_path = UploadFileHelper::uploadImage($input['upFile'],'upload/frontend/company_file/');
            DB::beginTransaction();
            try{
                //添加认证表
                $authentication = new Authentication();
                $authentication->user_id = $this->getId();
                $authentication->name = $input['name'];
                $authentication->credit_code = $input['credit_code'];
                $authentication->status = 0;
                $authenticationRes = $authentication->save();
                //添加到true_firm_info
                $true_firm_info = new TrueFirmInfo();
                $true_firm_info->user_id = $this->getId();
                $true_firm_info->license_group_id = $input['credit_code'];
                $true_firm_info->license_img = $file_path;
                $true_firm_infoRes = $true_firm_info->save();
                //添加到user表
                $user_info = User::where('id',$_COOKIE['user_id'])
                    ->update([
                        'name'=>$input['name'],
                        'real_name'=>$input['name'],
                        'code'=>$input['credit_code']
                    ]);
                DB::commit();
                return "<script>alert('信息录入成功，请耐心等候审核');location.href = '/information';</script>";
            }catch (Exception $e){
                DB::rollBack();
                return "<script>alert('数据录入失败，请稍后重试');history.back();</script>";
            }
        }else{
            //非三证合一
            $file_path = UploadFileHelper::uploadImage($input['upFile'],'upload/frontend/company_file/');
            DB::beginTransaction();
            try{
                //添加认证表
                $authentication = new Authentication();
                $authentication->user_id = $this->getId();
                $authentication->name = $input['name'];
                $authentication->code = $input['code'];
                $authentication->license_code = $input['license_code'];
                $authentication->tax_code = $input['tax_code'];
//                $authentication->credit_code = $input['credit_code'];
                $authentication->status = 0;
                $authenticationRes = $authentication->save();
                //添加到true_firm_info
                $true_firm_info = new TrueFirmInfo();
                $true_firm_info->user_id = $this->getId();
                $true_firm_info->license_group_id = $input['license_code'];
                $true_firm_info->license_img = $file_path;
                $true_firm_infoRes = $true_firm_info->save();
                //添加到user表
                $user_info = User::where('id',$_COOKIE['user_id'])
                    ->update([
                        'name'=>$input['real_name'],
                        'real_name'=>$input['real_name'],
                        'code'=>$input['license_code']
                    ]);
                DB::commit();
                return "<script>alert('信息录入成功，请耐心等候审核');location.href = '/information';</script>";
            }catch (Exception $e){
                DB::rollBack();
                return "<script>alert('数据录入失败，请稍后重试');history.back();</script>";
            }
        }
    }
    
    //人员管理
    public function staff($status)
    {
        if($status == 'all'){
            $data = DB::table('order')
                ->join('warranty_recognizee','order.id','warranty_recognizee.order_id')
                ->join('product','order.ty_product_id','product.ty_product_id')
                ->where('order.user_id',$this->getId())
                ->groupBy('warranty_recognizee.code')
                ->select('warranty_recognizee.*','product.product_name','order.start_time')
                ->get();
            $count = count($data);
        }elseif($status == 'deleted'){

        }
//        dd($data);
        return view('frontend.guests.mobile.company.staff',compact('count','data'));
    }

    //人员添加
    public function staffAdd()
    {
        $products = DB::table('order')
            ->join('product','order.ty_product_id','product.ty_product_id')
            ->where('order.user_id',$this->getId())
            ->groupBy('product.ty_product_id')
            ->select('product.product_name','product.ty_product_id')
            ->get();
//        dd($products);
        if($this->is_mobile()){
            return view('frontend.guests.mobile.company.add_staff',compact('products'));
        }
        return view('frontend.guests.mobile.company.add_staff',compact('products'));
    }

    //数据提交
    public function staffAddSubmit(Request $request)
    {
        $input = $request->all();
//        dd($input);
        DB::beginTransaction();
        try{
            $add = new AddRecoginzee();
            $add->user_id = $this->getId();
            $add->name = $input['name'];
            $add->sex = $input['sex'];
            $add->id_type = $input['id_type'];
            $add->date = $input['date'];
            $add->project = $input['product'];
            $add->id_code = $input['id_code'];
            $add->phone = $input['phone'];
            $add->status = 1;
            $res = $add->save();
            if($res)
            {
                DB::commit();
                return "<script>alert('添加成功');location.href='/cpersonal/staff';</script>";
            }else{
                return "<script>alert('添加失败');history.back();</script>";
            }
        }catch (Exception $e){
            DB::rollBack();
            return "<script language=javascript>alert('添加失败,请稍后再试');history.back();</script>";
        }
    }

    //人员删除
    public function delete($id)
    {
        $data = Order::where('id',$id)
            ->with('product','warranty_recognizee')->first();
//        print_r($data);die;
        if($data->warranty_recognizee){
            DB::beginTransaction();
            try{
                $add_res = new AddRecoginzee();
                $add_res->user_id = Auth::user()->id;
                $add_res->name = $data->warranty_recognizee['name'];
                $add_res->id_type = 1;
                $add_res->date = date('Y-m-d H:i:s',time());
                $add_res->project = $data->product['product_name'];
                $add_res->id_code = $data->warranty_recognizee['code'];
                $add_res->phone = Auth::user()->id;
                $add_res->status = Auth::user()->id;
            }catch (Exception $e){
                DB::rollBack();
                return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
            }
        }
    }


    //数据统计
    public function datas()
    {
        return view('frontend.guests.mobile.company.datas');
    }
}
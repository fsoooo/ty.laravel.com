<?php
namespace App\Http\Controllers\FrontendControllers\GuestControllers;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\Contacts;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MpersonalController extends BaseController{
    public function manage()
    {
        if($this->is_person($this->getId()) == 1){
            return view('frontend.guests.mobile.personal.manage');
        }else{
            return view('frontend.guests.mobile.company.manage');
        }

    }

    //常用联系人
    public function contact()
    {
        $data = Contacts::where('user_id',Auth::user()->id)
            ->get();
        $count = count($data);
//        dd($data);
        return view('frontend.guests.mobile.personal.contact',compact('data','count'));
    }

    //加人
    public function addPerson()
    {
        return view('frontend.guests.mobile.personal.add_person');
    }

    //加人数据提交
    public function addSubmit(Request $request)
    {
        $input = $request->all();
//        $validator = $this->checkPost($input);
//        if($validator->fails()){
//            return redirect('/mpersonal/addperson')
//                ->withErrors($validator)
//                ->withInput();
//        }
        DB::beginTransaction();
        try{
            $contacts = new Contacts();
            $contacts->name = $input['name'];
            $contacts->id_type = $input['id_type'];
            $contacts->birthday = $input['birthday'];
            $contacts->id_code = $input['id_code'];
            $contacts->email = $input['email'];
            $contacts->user_id = Auth::user()->id;
            $contacts->phone = $input['phone'];
            $contacts->address = $input['address'];
            $contacts->inAddress = $input['inAddress'];
            $contacts->postCode = $input['postCode'];
            $res = $contacts->save();
            if($res){
                DB::commit();
                return ['status'=>200,'msg'=>'添加成功'];
            }else{
                return ['status'=>400,'msg'=>'添加失败'];
            }
        }catch (Exception $e){
            DB::rollBack();
            return ['status'=>401,'msg'=>'添加失败'];
        }

    }

    //修改密码
    public function changePsw()
    {
        return view('frontend.guests.mobile.personal.chang_psw');
    }

    //个人信息
    public function info()
    {
        $data = User::find($this->getId());
        return view('frontend.guests.mobile.personal.information',compact('data'));
    }

    //个人信息提交
    public function infoSubmit(Request $request)
    {
        $input = $request->all();
        $id = $this->getId();
        $User = User::find($id);
        $change_array = array(
            'name'=>$input['name']??' ',
            'real_name'=>$input['name']??' ',
            'code'=>$input['id_code']??' ',
            'address'=>$input['address']??' '.$input['addressDetails']??' ',
        );
        $result = $this->edit($User,$change_array);
//        dd($result);
        if($result){
            return "<script>alert('修改完成');history.back();</script>";
        }else{
            return "<script>alert('修改失败');history.back();</script>";
        }
    }



    //修改投保人信息 验证
    protected function checkPost($input)
    {
        //规则
        $rules = [
            'name' => 'required',
            'id_type' => 'required',
            'birthday' => 'required',
            'id_code' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'inAddress' => 'required',
            'postCode'=>'required',
        ];
        //自定义错误信息
        $messages = [
            'required' => 'The :attribute is null.',
            'integer' => 'The :attribute mast be integer.',
            'string' => 'The :attribute mast be string.',
        ];
        //验证
        $validator = Validator::make($input, $rules, $messages);
        return $validator;
    }

    //订单详情
    public function orderDetail($code)
    {
        $data = Order::with('product')
            ->with('order_parameter')
            ->with('warranty_recognizee')
            ->where('order_code',$code)
            ->first();
        $duty = json_decode($data->order_parameter[0]->parameter,true);
        $duty = json_decode($duty['protect_item'],true);
//        dd($duty);
//        dd($data);
        return view('frontend.guests.mobile.personal.order_detail',compact('code','data','duty'));
    }

    public function notFound()
    {
        return view('frontend.guests.mobile.not_found');
    }

}
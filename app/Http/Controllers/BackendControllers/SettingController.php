<?php

namespace App\Http\Controllers\BackendControllers;

use App\Services\UploadImage;
use Illuminate\Http\Request;
use App\Models\Setting;

/**
 * 个性化设置
 *
 * @category   Controller
 * @package    Api
 * @author     房玉婷 <fangyt@inschos.com>
 * @copyright  2017 (C) 北京天眼互联科技有限公司
 * @version    1.0.0
 * @since      v1.0
 */
class SettingController extends BaseController
{

    private $setting;

    public function __construct(Request $request, Setting $setting)
    {
        parent::__construct($request);
        $this->setting = $setting;
    }

    /**
     * 个性化设置列表页
     */
    public function index(Request $request)
    {
        //获取当前个性化设置的内容
        $setting_list = $this->setting->get();
        foreach ($setting_list as $value){
            $setting[$value['name']] = $value['content'];
        }
        return view('backend_v2.setting.index',compact('setting'));
    }

    /**
     * 保存个性化设置
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $input =  $request->all();

        $i = 0;
        $setting = [];
        foreach ($input as $key=>$value){
            $setting_list = $this->setting->where('name',$key)->first();
            if(is_null($setting_list) && !is_null($value)){//没有此配置项并且配置项内容不为空
                $setting[$i]['name'] = $key;
                $setting[$i]['content'] = $value;
                $setting[$i]['type'] = 1;//配置项
                $setting[$i]['created_at'] = date('Y-m-d H:i:s',time());
                $setting[$i]['updated_at'] = date('Y-m-d H:i:s',time());
            }elseif (!is_null($setting_list)){//已经有此配置项
                $this->setting->where('id',$setting_list['id'])->update(['content'=>$value]);
            }
            //忽略没有此配置项并且配置项为空的数据
            $i++;
        }
//        return $setting;
        //如果有需要插入的数据，执行insert
        if(!empty($setting)){
            $this->setting->insert($setting);
        }
        return redirect('backend/setting/')->with('status', '保存成功！');
    }

    /**
     * 把base64转换成image上传到服务器
     *
     * @param Request $request
     * @return bool|string
     */
    public function uploadImage(Request $request)
    {
        $base64 = $request->get('url');
//        var_export($base64);exit;
        $path = 'backend/setting/' . date("Ymd") .'/';

        $output_file = UploadImage::uploadImageWithBase($base64,$path);
        return $path.$output_file;
    }

}
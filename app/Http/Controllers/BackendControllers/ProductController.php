<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\Ditch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\Label;
use App\Models\LabelRelevance;
use App\Models\ProductDownReason;
use App\Models\WarrantyRule;
use App\Models\Tariff;
use App\Helper\Email;
use App\Helper\MakeSign;
use Cache;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use App\Helper\Relevance;
use App\Helper\UploadFileHelper;
use Illuminate\Contracts\Support\JsonableInterface;

class ProductController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->relevance = new Relevance();
        $this->request = $request;
    }
    //获取天眼后台产品池数据
    //todo 缓存
    public function getProducts(Request $request,$input)
    {
        $sign_help = new RsaSignHelp();
        $page = isset($input['page']) ? $input['page'] : 1;
        $product_ids = Product::where('status','1')->where('ty_product_id','>=',0)->get();
        $ty_product_id = [];
        foreach ($product_ids as $value){
            $ty_product_id[] = $value['ty_product_id'];
        }
        $biz_content = [];
        $biz_content['page'] = $page;
        $biz_content['ids'] = $ty_product_id;
//        $biz_content['sell_status'] = env('TY_PRODUCT_STATUS', 2);
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/getdata')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//         print_r($response->content);exit;
        if($response->status != 200)
            return (['status' => '1', 'message' => '服务器链接失败']);
        $content = $response->content;
        $content = json_decode($content, true);
        $data = $content['data'];
        if (empty($data['result']))
            return (['status' => '1', 'message' => '暂无产品可上架']);
        $res = [];
        $res['res'] = $data['result'];
        $res['currentPage'] = $data['limit']['page'];    //当前页
        $res['pages'] = $data['limit']['pages']; //总页数
        $res['total'] = $data['limit']['count']; //产品总数
        $res['category'] = $data['category']; //分类集合
        $res['companys'] = $data['companys']; //保险公司集合
        $return_data = ['status'=> 0, 'message'=> $res];
//         //存缓存（有效期为12小时）
//        $expiresAt = \Carbon\Carbon::now()->addMinutes(24*60);
//        Cache::forever('ty_product_res_'.$page, $return_data,$expiresAt);
        return $return_data;
    }
    //产品池/待售产品列表
    //todo  缓存
    public function productStayOn(Request $request)
    {
        $input = $request->all();
        $page = isset($input['page']) ? $input['page'] : 1;
        $products = Product::where('delete_id', '0')->where('ty_product_id','>=',0)->select('ty_product_id')->get();
        $product_id = [];
        foreach ($products as $product) {
            $product_id[] = $product['ty_product_id'];
        }
        $products_up = Product::where('delete_id', '0')->where('status','1')->where('ty_product_id','>=',0)->select('ty_product_id')->get();
        $product_up_id = [];
        foreach ($products_up as $product) {
            $product_up_id[] = $product['ty_product_id'];
        }
//        //查询是否存在缓存
        //todo 缓存
//        if (Cache::has('ty_product_res')) {
//            $res = Cache::get('ty_product_res_'.$page);
//        }else{
            $res = $this->getProducts($request,$input);
//        }
        //同步失败
        if($res['status'] == 1)
            return redirect('/backend/product/product_list')->with('status', $res['message']);;
        //查询是否存在缓存
//        if (Cache::has('ty_product_categorys')) {
//            $categorys = Cache::get('ty_product_categorys');
//        }else{
            $categorys = $this->productGetCategory($res['message']['category']);
//        }
//        dump($categorys);
//        dump($res['message']);
//        dd($this->getProductApiInfo($res['message']['res']));
//        dump($this->getProductApiInfo(1));
        if(isset($request['keyword'])){
            $keyword = $request['keyword'];
            if(preg_match('/-/',$keyword)&&$request['search_type']!='ins_up'){
                $keyword = preg_replace('/-/','',$keyword);
            }
            $select_res = [];
            switch($request['search_type']){
                case 'ins_up':
                    foreach ($res['message']['res'] as $value){
                        if($keyword==date('Y-m-d',strtotime($value['created_at']))){
                            $select_res[] = $value;
                        }
                    }
                    break;
                case 'ins_company':
                    foreach ($res['message']['res'] as $value){
                        if(strstr($value['company']['display_name'],$keyword)){
                            $select_res[] = $value;
                        }
                    }
                    break;
                case 'ins_company_type':
                    foreach ($res['message']['res'] as $value){
                        if(strstr($value['company']['display_name'],$keyword)){
                            $select_res[] = $value;
                        }
                    }
                    break;
                case 'ins_main_type':
                    foreach ($res['message']['res'] as $value){
                        if(strstr($value['category']['name'],$keyword)){
                            $select_res[] = $value;
                        }
                    }
                    break;
                case 'ins_other_type':
                    foreach ($res['message']['res'] as $value){
                        if(strstr($value['category']['name'],$keyword)){
                            $select_res[] = $value;
                        }
                    }
                    break;
                case 'ins_type':
                    foreach ($res['message']['res'] as $value){
                        if(strstr($value['name'],$keyword)){
                            $select_res[] = $value;
                        }
                    }
                    break;
            }
            if(!empty($select_res)){
                $res['message']['res'] = $select_res;
            }else{
                $res['message']['res'] = [];
            }
        }
        return view('backend_v2.product.product_stay_on')
            ->with('res', $res['message']['res'])
            ->with('categorys', $categorys)
            ->with('totals', $res['message']['total'])
            ->with('currentPage', $res['message']['currentPage'])
            ->with('pages', $res['message']['pages'])
            ->with('companys', $res['message']['companys'])
            ->with('product_up_id', $product_up_id)
            ->with('product_id', $product_id);

    }
    //产品池/待售产品详情
    //todo  缓存
    public function productDetails($product_id){
        $productInfo_cache_key = 'product_info_'.$product_id;
        $product_res = Product::where('ty_product_id',$product_id)->first();
        if(is_null($product_res)){
            $product_sync = '0';//未同步
            $product_status = '0';//未同步
        }else{
            $product_sync = '1';//已同步
            if($product_res->status){
                $product_status = '1';//已上架
            }else{
                $product_status = '0';//未上架
            }
        }
//        //查询缓存
//        if (Cache::has($productInfo_cache_key)) {
//            $content = Cache::get($productInfo_cache_key);
//            dd($content);
//            return view('backend_v2.product.product_details')
//                ->with('product_sync', $product_sync)
//                ->with('product_status', $product_status)
//                ->with('product_res', $content);
//        }
        $biz_content = array('productid' => $product_id);
        $sign_help = new RsaSignHelp();
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/getproductinfo')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//        print_r($response);die;
        $content = $response->content;
        $status = $response->status;
        if ($status == '200') {
            $content = json_decode($content, true);
            if (!is_array($content)) {
                return back()->withErrors('数据解析错误，请稍等...');
            }
            $res = $content['data']['res'];
            $clause = $content['data']['clause'];
            $category = $content['data']['category'];
            $content = [];
            $content['res'] = $res;
            $content['clause'] = $clause;
            $content['category'] = $category;
//            dump($content);
//            //存缓存（有效期为12小时）
//            $expiresAt = \Carbon\Carbon::now()->addMinutes(24*60);
//            Cache::forever($productInfo_cache_key, $content,$expiresAt);
            return view('backend_v2.product.product_details')
                ->with('product_sync', $product_sync)
                ->with('product_status', $product_status)
                ->with('product_res', $content);
        } else {
            return (json_encode(['status' => '1', 'message' => '无服务'],JSON_UNESCAPED_UNICODE));
        }
    }
    //把产品池的产品加入我的列表
    public function addProductLists(Request $request)
    {
        //选中产品的页码和ID
        $id = isset($request->ty_product_id) ? $request->ty_product_id : '';
        if(empty($id)){
            return back()->withErrors('请选择上架的产品！');
        }
        $id = rtrim($id, ',');
        $id = explode(",", $id);
        $biz_content = array('product_id' => $id);
        $sign_help = new RsaSignHelp();
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/getproducts')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//        print_r($response);die;
        $content = $response->content;
        $status = $response->status;
//        dd(json_decode($content,true));
        if ($status != '200')
            return (json_encode(['status' => 1, 'message' => '同步失败'],JSON_UNESCAPED_UNICODE));
        $content = json_decode($content, true);
        if (!is_array($content)) {
            return (json_encode(['status' => 1, 'message' => '数据解析错误！请稍后重试...'],JSON_UNESCAPED_UNICODE));
        }
        $res = $content['data']['res'];
        $clauses = $content['data']['clause'];
        $category = $content['data']['category'];
        foreach ($res as $value) {
            $value['categorys'] = $category;
            $id = $value['id'];
            $name = $value['name'];
            $res = Product::firstOrCreate(['ty_product_id' => $id]);
            $company_name = $value['company']['name'];
            $company_email = $value['company']['email'];
            $res->ty_product_id = $value['id'];
            $res->product_name = $name;
            $res->insure_type = $value['type'];
            $res->company_name = $company_name;
            $res->company_email = $company_email;
            $res->base_price = $value['base_price'];
            $res->base_stages_way = $value['base_stages_way'];
            $res->base_ratio = $value['base_ratio'];
            $res->private_p_code = $value['insurance_api_info']['private_p_code'];
            $res->product_number = $value['insurance_api_info']['p_code'];
            $res->status = '1';
            $res->delete_id = '0';
            $res->personal = '';
            $res->cover = '/r_backend/v2/img/396658748210103920.jpg';
            $res->product_category = $value['category']['name'];
            $res->json = json_encode($value);
            $res->clauses = json_encode($value['clauses']);
            $res->created_at = $res->updated_at = date('Y-m-d H:i:s');
            $res->save();
        }
        return (json_encode(['status' => 0, 'message' => '上架成功'],JSON_UNESCAPED_UNICODE));
    }
    //把待售产品上架
    public function addProductUp(Request $request)
    {
        //选中产品ID
        $id = $request->id;
        $id = rtrim($id, ',');
        $arr = explode(",", $id);
        foreach ($arr as $id) {
            $res = Product::where('ty_product_id', $id)->update(['status' => '1']);
        }
        if ($res) {
            return (json_encode(['status' => 0, 'message' => '上架成功'],JSON_UNESCAPED_UNICODE));
        } else {
            return (json_encode(['status' => 1, 'message' => '上架失败'],JSON_UNESCAPED_UNICODE));
        }
    }
    //代售产品个性化编辑
    //todo  缓存
    public function productDetailsEdit(Request $request,$id){
        //todo   编辑页面从缓存里取数据
        $productInfo_cache_key = 'product_info_'.$id;
        $product_sync = Product::where('ty_product_id',$id)->first();
        if(is_null($product_sync)){
            $product_sync = '0';//未同步
        }else{
            $product_sync = '1';//已同步
        }
        $global_labels = Label::where('parent_id','0')
            ->where('label_belong','product')
            ->where('label_type','global')
            ->where('status','0')
            ->get();
        $special_labels = Label::where('parent_id','0')
            ->where('label_belong','product')
            ->where('label_type','special')
            ->where('status','0')
            ->get();
        $labels_special_res = Label::where('label_belong','product')
            ->where('parent_id','<>','0')
            ->where('label_type','special')
            ->where('status','0')
            ->get();
        $labels_global_res = Label::where('label_belong','product')
            ->where('parent_id','<>','0')
            ->where('label_type','global')
            ->where('status','0')
            ->get();
        $product_labels = LabelRelevance::where('label_relevance',$id)
            ->where('label_belong','product')
            ->select('label_id')
            ->get();
        if(!empty($product_labels)){
            $product_labels_res = Label::whereIn('id',$product_labels)
                ->where('label_belong','product')
                ->get();
        }
        //查询缓存
        if (Cache::has($productInfo_cache_key)) {
            $content = Cache::get($productInfo_cache_key);
            return view('backend_v2.product.product_details_edit')
                ->with('product_labels_res', $product_labels_res)
                ->with('global_labels', $global_labels)
                ->with('special_labels', $special_labels)
                ->with('labels_global_res', $labels_global_res)
                ->with('labels_special_res', $labels_special_res)
                ->with('product_sync', $product_sync)
                ->with('product_res', $content);
        }else{
            $biz_content = array('productid' => $id);
            $sign_help = new RsaSignHelp();
            $data = $sign_help->tySign($biz_content);
            $response = Curl::to(env('TY_API_SERVICE_URL') . '/getproductinfo')
                ->returnResponseObject()
                ->withData($data)
                ->withTimeout(60)
                ->post();
            $content = $response->content;
            $status = $response->status;
            if ($status == '200') {
                $content = json_decode($content, true);
                $res = $content['data']['res'];
                $clause = $content['data']['clause'];
                $category = $content['data']['category'];
                $content = [];
                $content['res'] = $res;
                $content['clause'] = $clause;
                $content['category'] = $category;
                //存缓存（有效期为12小时）
                $expiresAt = \Carbon\Carbon::now()->addMinutes(24*60);
                Cache::forever($productInfo_cache_key, $content,$expiresAt);
            } else {
                return (json_encode(['status' => '1', 'message' => '无服务'],JSON_UNESCAPED_UNICODE));
            }
            return view('backend_v2.product.product_details_edit')
                ->with('product_labels_res', $product_labels_res)
                ->with('global_labels', $global_labels)
                ->with('special_labels', $special_labels)
                ->with('labels_global_res', $labels_global_res)
                ->with('labels_special_res', $labels_special_res)
                ->with('product_sync', $product_sync)
                ->with('product_res', $content);
        }
    }
    //代售产品个性化编辑处理
    public function doProductDetailsEdit(Request $request){
        $input = $request->all();
        $product_res = Product::where('ty_product_id',$input['ty_product_id'])->first();
        if(is_null($product_res)){
            $sync  = $this->addProductLists($request);
        }
        if(isset($input['product_cover'])){
            if(is_string($input['product_cover'])){
                $product_cover_path =$input['product_cover'];
            }else{
                $path = 'upload/backend/product/cover' . date("Ymd") .'/';
                $product_cover_path = UploadFileHelper::uploadImage($input['product_cover'], $path);//产品封面上传图片路径（存数据库）
            }
            $res = Product::where('ty_product_id',$input['ty_product_id'])->update([
                'cover'=>empty($product_cover_path)? '':$product_cover_path,
                'status'=>'1',
            ]);
        }
        $person_img_paths = [];
        if(isset($input['person_img'])){
            foreach ($input['person_img'] as $key=>$value){
                if(is_string($value)){
                    $image_path = $value;
                }else{
                    $path = 'upload/backend/product/person' . date("Ymd") .'/';
                    $image_path = UploadFileHelper::uploadImage($value, $path);//理赔上传图片路径（存数据库）
                }
                $person_img_paths[$key] = $image_path;
            }
            $res = Product::where('ty_product_id',$input['ty_product_id'])->update([
                'personal'=>empty($person_img_paths) ? '': json_encode($person_img_paths),
                'status'=>'1',
            ]);
        }
       if(!isset($res)){
           return redirect('/backend/product/product_details_edit/'.$input['ty_product_id'])->withErrors( '请选择上传的数据!');
       }
        if(!$res){
            return redirect('/backend/product/product_details_edit/'.$input['ty_product_id'])->withErrors('个性化编辑失败!');
        }else{
            return redirect('/backend/product/product_list')->with('status', '个性化编辑成功!');
        }
    }
    //我的产品列表
    //todo  缓存
    public function productList()
    {
        $request = $this->request->all();
        $product_res = Product::where('sale_status','0')
            ->where('status','1')
            ->where('ty_product_id','>=',0);
        $where = array();
        if(isset($request['keyword'])){
            $keyword = $request['keyword'];
            if(preg_match('/-/',$keyword)&&$request['search_type']!='ins_up'){
                $keyword = preg_replace('/-/','',$keyword);
            }
            switch($request['search_type']){
                case 'ins_name':
                    $where[] = ['product_name', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_main_type':
                    $where[] = ['product_category', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_up':
                    $where[] = ['created_at', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_company':
                    $where[] = ['company_name', 'like', '%'. $keyword .'%'];
                    break;
            }
        }
        $product_res = $product_res->where($where)->paginate(config('list_num.backend.product'));
        $company_res = Product::where('status','1')
            ->where('sale_status','0')
            ->where('ty_product_id','>=',0)
            ->get();
        $companys = [];
        foreach ($company_res as $value){
            $companys[] = $value['company_name'];
        }
        $companys = array_unique($companys);
        //查询是否存在缓存
//        if (Cache::has('ty_product_categorys')) {
//            $categorys = Cache::get('ty_product_categorys');
//        }else{
//            if(count($product_res)>0){
                $categorys = $this->productGetCategory($product_res);
//            }else{
//                $categorys  = [];
//            }
//        }
//        dump($companys);
        return view('backend_v2.product.product_list')
            ->with('categorys',$categorys)
            ->with('companys',$companys)
            ->with('res',$product_res);
    }
    //我的产品列表产品下架
    public  function addProductDown(Request $request){
        //选中产品ID
        $id = $request->id;
        $id = rtrim($id, ',');
        $arr = explode(",", $id);
        foreach ($arr as $id) {
            $res = Product::where('ty_product_id', $id)->update([
                'cover'=>'',
                'personal'=>'',
                'status'=>0,
            ]);
            LabelRelevance::where('label_relevance',$id)->delete();
//            $res = Product::where('ty_product_id', $id)->delete();
        }
        if($res){
            return (json_encode(['status' => 0, 'message' => '下架成功'],JSON_UNESCAPED_UNICODE));
        }else{
            return (json_encode(['status' => 1, 'message' => '下架失败'],JSON_UNESCAPED_UNICODE));
        }
    }
    //我的产品详情
    //todo  缓存
    public function productDetailsOn(Request $request,$id){
        $product_res = Product::where('id',$id)->first();
        $product_labels_res = [];
        if(!is_null($product_res)){
            $product_labels = LabelRelevance::where('label_relevance',$product_res['ty_product_id'])
                ->where('label_belong','product')
                ->select('label_id')
                ->get();
            if(!empty($product_labels)){
                $product_labels_res = Label::whereIn('id',$product_labels)
                    ->where('label_belong','product')
                    ->get();
            }
        }
        if($product_res->status){
            $product_status = '1';//已上架
        }else{
            $product_status = '0';//未上架
        }
//        dd(json_decode($product_res['json'],true));
//        dd($product_res['clauses']);
        return view('backend_v2.product.product_details_on')
            ->with('product_labels_res',$product_labels_res)
            ->with('product_status',$product_status)
            ->with('product_res',$product_res);
    }
    //停售产品列表
    public function productSoldOut()
    {
        $request = $this->request->all();
        $product_res = Product::where('sale_status','1')->where('ty_product_id','>=',0);
        $where = array();
        if(isset($request['keyword'])){
            $keyword = $request['keyword'];
            switch($request['search_type']){
                case 'ins_name':
                    $where[] = ['product_name', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_up':
                    $where[] = ['created_at', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_company':
                    $where[] = ['company_name', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_company_type':
                    $where[] = ['company_name', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_main_type':
                    $where[] = ['product_category', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_other_type':
                    $where[] = ['product_category', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_type':
                    $where[] = ['product_category', 'like', '%'. $keyword .'%'];
                    break;
            }
        }
        $product_res = $product_res->where($where)->paginate(config('list_num.backend.product'));
        //查询是否存在缓存
        if (Cache::has('ty_product_categorys')) {
            $categorys = Cache::get('ty_product_categorys');
        }else{
            if(count($product_res)>0){
                $categorys = $this->productGetCategory($product_res);
            }else{
                $categorys  = [];
            }
        }
        $company_res = Product::where('status','1')
            ->where('sale_status','1')
            ->where('ty_product_id','>=',0)
            ->get();
        $companys = [];
        foreach ($company_res as $value){
            $companys[] = $value['company_name'];
        }
        $companys = array_unique($companys);
        return view('backend_v2.product.product_sold_out')
            ->with('categorys',$categorys)
            ->with('companys',$companys)
            ->with('res',$product_res);
    }
    //下架产品详情
    public function productSoldOutDetails(Request $request,$id){
        $product_res = Product::where('id',$id)->with('product_down_reason')->first();
        return view('backend_v2.product.product_sold_out_details')
            ->with('product_res',$product_res);
    }
    //天眼后台获取分类
    //todo  缓存
    public function productGetCategory($res){
        //直到五级分类
        $categorys = isset($res[0]['json']) ? json_decode($res[0]['json'],true)['categorys'] : $res;
        $one  = [];
        $two  = [];
        $three  = [];
        $four  = [];
        $five  = [];
        foreach($categorys as $v){
            $name = str_repeat('-' , $v['sort']) . $v['name'];
            if(preg_match('/-/', $name)){
                if(preg_match('/--/', $name)){
                    if(preg_match('/---/', $name)){
                        if(preg_match('/----/', $name)){
                            $five[$v['path'].'-'.$v['id']] = $name;
                        }else{
                            $four[$v['path'].'-'.$v['id']] = $name;
                        }
                    }else{
                        $three[$v['path'].'-'.$v['id']] = $name;
                    }
                }else{
                    $two[$v['path'].'-'.$v['id']] = $name;
                }
            }else{
                $one[$v['path'].'-'.$v['id']] = $name;
            }
        }
        foreach ($one as $key=>$value){
            foreach ($two as $key_two=>$value_two){
                if(explode("-", $key)[0].explode("-", $key)[1].','==explode("-", $key_two)[0]){
                    if(explode("-", $key)[1]=='1'){
                        $company_category[explode("-", $key_two)[1]] = $value_two;
                    }
                    if(explode("-", $key)[1]=='2'){
                        $insurance_category[explode("-", $key_two)[1]] = $value_two;
                    }
                    if(explode("-", $key)[1]=='3'){
                        $clause_category[explode("-", $key_two)[1]] = $value_two;
                    }
                    if(explode("-", $key)[1]=='4'){
                        $duty_category[explode("-", $key_two)[1]] = $value_two;
                    }
                }
            }
        }
        foreach ($three as $key_three=>$value_three){
            foreach ($company_category as $k_c=>$v_c){
                if(explode(',',explode("-", $key_three)[0])[3]==$k_c){
                    $company_category[$k_c.'-'.explode("-", $key_three)[1]]=$value_three;
                }
            }
        }
        foreach ($three as $key_three=>$value_three){
            foreach ($insurance_category as $k_c=>$v_c){
                if(explode(',',explode("-", $key_three)[0])[3]==$k_c){
                    $insurance_category[$k_c.'-'.explode("-", $key_three)[1]]=$value_three;
                }
            }
        }
        foreach ($four as $k=>$v){
            foreach ($company_category as $k_c=>$v_c){

                if(count(explode('-',$k_c))=='2'){
                    if(explode(',',explode('-',$k)[0])[4]==explode('-',$k_c)[1]){
                        $company_category[$k_c.'-'.explode("-", $k)[1]]=$v;
                    }
                }
            }
        }
        foreach ($four as $k=>$v){
            foreach ($insurance_category as $k_c=>$v_c){
                if(count(explode('-',$k_c))=='2'){
                    if(explode(',',explode('-',$k)[0])[4]==explode('-',$k_c)[1]){
                        $insurance_category[$k_c.'-'.explode("-", $k)[1]]=$v;
                    }
                }
            }
        }
        $return_data = array(
            'company' => isset($company_category)? $company_category : [],
            'insurance' => isset($insurance_category)? $insurance_category:[],
            'clause' => isset($clause_category)? $clause_category:[],
            'duty' => isset($duty_category)? $duty_category:[],
        );
        //存缓存（有效期为12小时）
//        $expiresAt = \Carbon\Carbon::now()->addMinutes(24*60);
//        Cache::forever('ty_product_categorys', $return_data,$expiresAt);
        return $return_data;
    }
    //产品排行列表
    public function productRankList(){
        $request = $this->request->all();
        $product_res = Product::where('delete_id', '0')
            ->where('ty_product_id','>=',0)
            ->where('status','1')
            ->with(['market_ditch_relation'=>function($q){
                $q->where('status','on')->groupBy('ditch_id');
            }])
            ->with('product_label');
        $where = array();
        if(isset($request['keyword'])){
            $keyword = $request['keyword'];
            switch($request['search_type']){
                case 'ins_name':
                    $where[] = ['product_name', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_up':
                    $where[] = ['created_at', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_company':
                    $where[] = ['company_name', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_company_type':
                    $where[] = ['company_name', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_main_type':
                    $where[] = ['product_category', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_other_type':
                    $where[] = ['product_category', 'like', '%'. $keyword .'%'];
                    break;
                case 'ins_type':
                    $where[] = ['product_category', 'like', '%'. $keyword .'%'];
                    break;
                case 'rank_by_grade':
//                    $where[] = ['product_name', 'like', '%'. $keyword .'%'];
                    break;
                case 'rank_by_sale':
//                    $where[] = ['product_name', 'like', '%'. $keyword .'%'];
                    break;
            }
        }
        //产品详情
        $product_res = $product_res->where($where)->paginate(config('list_num.backend.product'));
//        dd($product_res);
        $company_res = Product::where('status','1')
            ->where('sale_status','0')
            ->where('ty_product_id','>=',0)
            ->get();
        $companys = [];
        foreach ($company_res as $value){
            $companys[] = $value['company_name'];
        }
        $companys = array_unique($companys);
        $product_ids = [];
        foreach ($product_res as $value){
            $product_ids[] = $value['ty_product_id'];
        }
        //产品销量
        $product_sales = Order::where('status','1')->select('ty_product_id')->get();
        $ty_product_ids = [];
        foreach ($product_sales as $value){
            $ty_product_ids[] = $value['ty_product_id'];
        }
        $product_sales_ids = array_count_values($ty_product_ids);
        arsort($product_sales_ids);//降序排列
        $product_sales_res = [];
        foreach ($product_ids as $id){
            if(!key_exists($id,$product_sales_ids)){
                $product_sales_ids[$id] = 0;
            }
        }
        foreach ($product_sales_ids as $key=>$value) {
            foreach ($product_ids as $id) {
                if ($id == $key) {
                    $product_sales_res[$id] = $value . '.' . $id;
                }
            }
        }
        rsort($product_sales_res);
        //查询是否存在缓存
        if (Cache::has('ty_product_categorys')) {
            $categorys = Cache::get('ty_product_categorys');
        }else{
            if(count($product_res)>0){
                $categorys = $this->productGetCategory($product_res);
            }else{
                $categorys  = [];
            }
        }
        return view('backend_v2.product.product_rank_list')
            ->with('product_sales_res',$product_sales_res)
            ->with('categorys',$categorys)
            ->with('companys',$companys)
            ->with('res',$product_res);
    }
    //产品下架原因处理
    public function productDownReason(Request $request){
        $input = $request->all();
        $res = ProductDownReason::insert([
            'ty_product_id'=>$input['ty_product_id'],
            'product_down_labels'=>isset($input['product_down_labels'])&&is_array($input['product_down_labels']) ? json_encode($input['product_down_labels']) : '',
            'product_down_content'=>isset($input['product_down_content'])? $input['product_down_content'] : '',
            'created_at'=>date('Y-m-d H:i:s',time()),
            'updated_at'=>date('Y-m-d H:i:s',time()),
        ]);
        if($res){
            return redirect('/backend/product/product_list')->with('status', '下架成功!');
        }else{
            return redirect('/backend/product/product_list')->with('status', '下架失败!');
        }
    }
    //产品销售统计
    public function productSaleStatistics($id){
        $product_res = Product::where('ty_product_id',$id)->first();
        $product_sale_res = WarrantyRule::where('ty_product_id',$id)
            ->with(['warranty','policy','product','brokerage'])
            ->join('agents', 'warranty_rule.agent_id', '=', 'agents.id')
            ->join('users', 'agents.user_id', '=', 'users.id')
            ->paginate(config('list_num.backend.product_sale'));
        return view('backend_v2.product.product_sale_statistics')
            ->with('product_sale_res',$product_sale_res)
            ->with('product_res',$product_res);
    }
    //产品评论
    public function productComment($id){
        $product_res = Product::where('id',$id)->first();
        return view('backend_v2.product.product_comment')
            ->with('product_res',$product_res);
    }
    //对象转化数组
    public function object2array($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }
    //获取产品详情（保障详情）
    public function getProductApiInfo($id){
        if(is_array($id)){
            $ids = [];
            foreach ($id as $value){
                $ids[] = $value['id'];
            }
        }
        $biz_content = [
            'ty_product_id' => is_array($id) ? $ids : $id,    //投保产品ID
        ];
        $sign_help = new RsaSignHelp();
        $biz_content = $sign_help->tySign($biz_content);
        //天眼接口参数封装
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/getapioption')
            ->returnResponseObject()
            ->withData($biz_content)
            ->withTimeout(120)
            ->post();
        print_r($response);
    }






















        //我的产品详情
    public function productInfo()
    {
        $object = Product::where('id', $_GET['id'])->first();
        $label_ids = LabelRelevance::where('product_id', $_GET['id'])->get();
        $product_id = $object->product_id;
        $json = $object->json;
        $json = json_decode($json, true);
        $clauses = $json['clauses'];
        $clauses_id = [];
        foreach ($clauses as $v) {
            $clauses_id[] = $v['id'];
        }
        $id = $object->id;
        $status = $object->status;
        $claus = $object->clauses;
        $claus = json_decode($claus, true);
        $label_check_id = [];
        foreach ($label_ids as $v){
                $label_check_id[] = $v['label_id'];
        }
        if(!is_null($object['cover'])){
            $json['cover']= $object['cover'];
        }
        if (empty($label_check_id)) {
            $label = [];
            return view('backend.product.productinfo')
                ->with('id', $id)
                ->with('status', $status)
                ->with('json', $json)
                ->with('labels', $label)
                ->with('claus', $claus)
                ->with('object', $object);
        } else {
            $labels = Label::wherein('id', $label_check_id)->get();
            $label = [];
            foreach ($labels as $v) {
                $label[] = $v;
            }
            return view('backend.product.productinfo')
                ->with('id', $id)
                ->with('status', $status)
                ->with('json', $json)
                ->with('labels', $label)
                ->with('claus', $claus)
                ->with('object', $object);
        }
    }
    //下架
    public function productDown()
    {
        $id = $_GET['id'];
        $id = rtrim($id, ',');
        $arr = explode(",", $id);
        foreach ($arr as $id) {
            $res = Product::where('id', $id)->update(['status' => 0]);
        }
        if ($res) {
            return (['status' => 0, 'message' => '下架成功']);
        } else {
            return (['status' => 1, 'message' => '产品已下架']);
        }
    }
    //产品修改
    public function productChange()
    {
        // return '产品修改';
        $res = Product::where('id', $_GET['id'])
            ->update([
                'price' => $_GET['price'],
                'description' => $_GET['descri'],
                'remark' => $_GET['remark']
            ]);
        if ($res) {
            return (['status' => 0, 'message' => '修改成功']);
        } else {
            return (['status' => 1, 'message' => '产品已修改完成']);
        }
    }
    //产品删除
    public function productDel()
    {
        $id = $_GET['id'];
        $id = rtrim($id, ',');
        $arr = explode(",", $id);
        foreach ($arr as $id) {
            $res = Product::where('id', $id)->update(['delete_id' => 1]);
        }
        if ($res) {
            return (['status' => 0, 'message' => '删除成功']);
        } else {
            return (['status' => 1, 'message' => '产品已删除']);
        }
    }
    //回收站
    public function productRec()
    {
        $params = "/backend/product/productrec";
        $limit = config('list_num.backend.roles');//每页显示几条
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $res = Product::where('delete_id', '1')->where('ty_product_id','>=',0)->paginate($limit);
        $pages = $res->lastPage();//总页数
        $totals = $res->total();//总数
        $currentPage = $res->currentPage();//当前页码
        $result = Product::where('delete_id', '1')
            ->where('ty_product_id','>=',0)
            ->with('product_label')
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();
        return view('backend.product.reclist')
            ->with('res', $result)
            ->with('params', $params)
            ->with('totals', $totals)
            ->with('currentPage', $currentPage)
            ->with('pages', $pages);
    }
    //产品还原
    public function productBack()
    {
        $id = $_GET['id'];
        $id = rtrim($id, ',');
        $arr = explode(",", $id);
        // var_dump($arr);
        foreach ($arr as $id) {
            $res = Product::where('id', $id)->update(['delete_id' => 0]);
        }
        if ($res) {
            return (['status' => 0, 'message' => '还原成功']);
        } else {
            return (['status' => 1, 'message' => '产品已还原']);
        }
    }
    //标签
    public function productLabels()
    {
        $limit = config('list_num.backend.roles');//每页显示几条
        $params = "/backend/product/productlabels";
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $res = Label::paginate($limit);
        $pages = $res->lastPage();//总页数
        $totals = $res->total();//总数
        $currentPage = $res->currentPage();//当前页码
        $result = Label::orderBy('order_by', 'asc')
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();
        return view('backend.product.labellists')
            ->with('res', $result)
            ->with('params', $params)
            ->with('totals', $totals)
            ->with('currentPage', $currentPage)
            ->with('pages', $pages);

    }
    //添加标签
    public function addLabel()
    {
        $res = Label::all()->where('parent_id', '0');
        // return '添加标签';
        return view('backend.product.addlabel')->with('res', $res);
    }
    //执行添加
    public function doAddLabel()
    {
        if (empty($this->request->name) || empty($this->request->description)) {
            return back()->withErrors('标题或内容不能为空！!');
        }
        //封面上传
        if(isset($this->request->file)){
            $path = 'upload/backend/label_cover/' . date("Ymd") .'/';
            $image_path = UploadFileHelper::uploadImage($this->request->file, $path);
        }else{
            $image_path  = '';
        }
        if(is_null($this->request->order_by)){
            $this->request->orderby = '0';
        }

        $res = label::insert([
            'name' => $this->request->name,
            'cover' => $image_path,
            'order_by' => $this->request->orderby,
            'description' => $this->request->description,
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time())
        ]);
        if ($res) {
            return redirect('/backend/product/productlabels')->with('status', '录入标签信息成功!');
        } else {
            return back()->withErrors('录入标签信息失败!');
        }
    }
    //修改标签
    public function updateLabel()
    {
        // return '修改标签';
        $res = Label::all()->where('parent_id', '0');//标签组
        $data = Label::all()->where('id', $_GET['id']);
        // dump($data);
        return view('backend.product.updatelabel')->with('res', $res)->with('data', $data);
    }
    //执行修改
    public function doUpdateLabel()
    {
        if (empty($this->request->name) || empty($this->request->description)) {
            return back()->withErrors('标题或内容不能为空！!');
        }
        if(is_null($this->request->order_by)){
            $this->request->order_by = '0';
        }
        //封面上传
        if(isset($this->request->file)){
            $path = 'upload/backend/label_cover/' . date("Ymd") .'/';
            $image_path = UploadFileHelper::uploadImage($this->request->file, $path);
        }else{
            $image_path  = $this->request->old_file;
        }
        $res = label::where('id',$this->request->id)->update([
            'name' => $this->request->name,
            'cover' => $image_path,
            'order_by' => $this->request->order_by,
            'description' => $this->request->description,
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time())
        ]);
        if ($res) {
            return back()->with('status', '修改标签信息成功!');
        } else {
            return back()->withErrors('修改标签信息失败!');
        }

    }
    public function productPersonal()
    {
        $data = $this->request->data;
        $product_id = $this->request->product_id;
        if(isset($this->request->file)){
            if(is_string($this->request->file)){
                $image_path = $this->request->file;
            }else{
                $path = 'upload/backend/product_cover/' . date("Ymd") .'/';
                $image_path    = UploadFileHelper::uploadImage($this->request->file, $path);
            }
        }else{
            if(is_null($data)){
                return back()->withErrors('内容不能为空！');
            }else{
                $image_path = ' ';
            }
        }
        $res = Product::where('ty_product_id', $product_id)
            ->update([
                'personal' => $data,
                'cover' => $image_path
            ]);
        if ($res) {
            return back()->with('status', '操作成功!');
        } else {
            return back()->withErrors('操作失败！');
        }
    }
    public function addProductLabel()
    {

        $r = Product::where('id', $_GET['product_id'])->first();
        $labels = Label::get();
        return view('backend.product.addproductlabel')
            ->with('res', $r)
            ->with('labels', $labels);
    }
    public function doAddProductLabel()
    {
        $id = $_GET['id'];
        $label_ids = rtrim($_GET['l_ids'], ',');
        $arr = array();
        if($label_ids)
            $arr = explode(',',$label_ids);
        $product = Product::where('id', $id)->first();
        $product->product_label()->sync($arr);
        return (['status' => 0, 'message' => "更新成功！!"]);
    }
    public function getLabelInfo()
    {
        $labels = Label::where('id', $_GET['id'])->first();
        $label = $labels->description;
        return (['status' => '0', 'label' => $label]);
    }
    public function getProductLables()
    {
        $limit = config('list_num.backend.roles');//每页显示几条
//        $params = "/backend/product/productlabels";
//        ->with('params', $params)
        $page = $_GET['page'];
        $res = Label::paginate($limit);
        $pages = $res->lastPage();//总页数
        $totals = $res->total();//总数
        $currentPage = $res->currentPage();//当前页码
        $result = Label::orderBy('order_by', 'asc')
            ->skip($page)
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();
        return (['status' => '0', 'data' => $result, 'pages' => $pages, 'totals' => $totals, 'currrentPage' => $currentPage]);
    }
    public function showProductLables()
    {
        if(!isset($_POST['label_id'])){
            return (['status' => '2']);
        }else{
            $label_id = $_POST['label_id'][0];
            $label_id = explode(',', $label_id);
            $labels = Label::whereIn('id', $label_id)->get();
            $label_name = [];
            foreach ($labels as $label) {
                $label_name[] = $label->name;
            }
            return (['status' => '0', 'labels' => $label_name]);
        }
    }
}
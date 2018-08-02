<?php
namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Excel;
use Ixudra\Curl\Facades\Curl;

// 指定允许其他域名访问
// 如果你的前端和后端不在一个域内
//header("Access-Control-Allow-Origin:http://localhost");
// 指定返回的是json
// 这样前端js接收的就是一个json对象，而不是json形式的字符串
// js就可以使用对象的访问方式：data.key
//header("Content-type: application/json");
class Test1Controller extends Controller
{
	public function index()
	{
		$data = [
				"notice_type"=> 'pay_call_back',
				'data' => [
						'status'=>true,
						'ratio_for_agency'=> ' ',
						'brokerage_for_agency'=> ' ',
						'union_order_code' => 'EC170901102018020117271970858',
						'by_stages_way' => ' ',
						'error_message' => '',
				]
		];
		$response = Curl::to('http://n183967a96.iask.in/ins/call_back')
				->returnResponseObject()
				->withData($data)
				->asJson()
				->withTimeout(60)
				->post();
	}
	//Excel文件导出功能 By Laravel学院
	public function export(){
		$cellData = [
			['学号','姓名','成绩'],
			['10001','AAAAA','99'],
			['10002','BBBBB','92'],
			['10003','CCCCC','95'],
			['10004','DDDDD','89'],
			['10005','EEEEE','96'],
		];
		Excel::create('学生成绩',function($excel) use ($cellData){
			$excel->sheet('score', function($sheet) use ($cellData){
				$sheet->rows($cellData);
			});
		})->export('xls');
	}

	public function test(Request $request)
	{
		$input = $request->all();
		return '前面是你刚刚传过来的数据';
	}

	public function testGet()
	{
		return 'Hello world!';
	}
	public function import(){
		$filePath = 'public/'.iconv('UTF-8', 'GBK', '232').'.xlsx';
		Excel::load($filePath, function($reader) {
			$data []= $reader->all(); //$data[]就是所要的数据
			dd($data);
			foreach($data[0][0] as $k=>$v){
				var_dump($v);
			}
		});

	}

	public function testVue()
	{
		return view('frontend.guests.dist.index');
	}
}
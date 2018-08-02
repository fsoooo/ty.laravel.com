<?php

namespace App\Services;

use App\Jobs\ImportPolicyOfflineJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Cache;
use Log;

/**
 * 读取包含图片的excel文件
 *
 * @category   Service
 * @package    Api
 * @author     房玉婷 <fangyt@inschos.com>
 * @copyright  2017 (C) 北京天眼互联科技有限公司
 * @version    1.0.0
 * @since      v1.0
 */
class ReadExcel
{
    /**
     * constructer.
     */
    public function __construct()
    {
    }

    /**
     * @param $file
     * @return bool
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public static function readExcel($file,$allowUpdate)
    {
        $extension = pathinfo($file['file']['name']);
        $extension = strtolower($extension["extension"]);
        //因为需要忽略第一行的内容，并且excel里存在图片，所以不能用laravel-excel
        if($extension == 'xls') {
            $reader = \PHPExcel_IOFactory::createReader('Excel5');
        }else if($extension == 'xlsx') {
            $reader = new \PHPExcel_Reader_Excel2007();
        }
        $objPHPExcelReader = $reader->load($file["file"]["tmp_name"]);
        $imageList = [];
        /** 读取图片内容 */
        if(count($objPHPExcelReader->getActiveSheet()->getDrawingCollection()) != 0) {
            foreach ($objPHPExcelReader->getActiveSheet()->getDrawingCollection() as $k => $drawing) {
                $codata = $drawing->getCoordinates(); //得到单元数据 比如G2单元
//            $filename = $drawing->getIndexedFilename();  //文件名

                if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {
                    ob_start();
                    call_user_func(
                        $drawing->getRenderingFunction(),
                        $drawing->getImageResource()
                    );
                    $imageContents = ob_get_contents();
                    ob_end_clean();
                    $imgExtension = 'png';
                } else {
                    $zipReader = fopen($drawing->getPath(), 'r');
                    $imageContents = '';

                    while (!feof($zipReader)) {
                        $imageContents .= fread($zipReader, 1024);
                    }
                    fclose($zipReader);
                    $imgExtension = $drawing->getExtension();
                }
                $path = 'backend/offline/' . date("Ymd") . '/';
                $output_file = time() . rand(100, 999) . '.' . $imgExtension;
                Storage::disk('upload')->put($path . $codata . $output_file, $imageContents);
                $imageList[$codata] = $path . $codata . $output_file;
            }
        }
//        exit;
        /** 读取文本内容 */
        $adminId = Auth::guard('admin')->user()->id;//当前登陆业管的ID 因为不止一个业管登陆可以导入线下单

        //缓存原文件名称（用来展示）
        \Cache::put('offlineExcelFileName'.$adminId,$file["file"]["name"],10);
        //缓存推送队列总数
        \Cache::put('offlineJobTotal'.$adminId,0,10);
        \Cache::put('offlineJobSuccess'.$adminId,0,10);
        \Cache::put('offlineJobUpdate'.$adminId,0,10);
        \Cache::put('offlineJobFail'.$adminId,0,10);
        foreach($objPHPExcelReader->getWorksheetIterator() as $sheet)  //循环读取sheet
        {
            foreach($sheet->getRowIterator() as $row)  //逐行处理
            {
                $data = [];
                if($row->getRowIndex()<3)  //确定从哪一行开始读取
                {
                    continue;
                }
                foreach ($row->getCellIterator() as $cell)  //逐列读取
                {
                    $data[] = $cell->getValue(); //获取cell中数据
//                    echo $data;
                }
                //导入的内容不能为空 并且 导入的一条数据不能全部为空
                if(count($data) != 0 && count(array_filter($data)) != 0) {
                    //图片保存入data
                    foreach (config('offline.imageExcelLine') as $attribute=>$column){
                        if(isset($imageList[$column.$row->getRowIndex()])){
                            //$data['policy_license_image'] = $imageList['AF3']
                            $data[$attribute] = '/upload/'.$imageList[$column.$row->getRowIndex()];
                        }
                    }
                    //有重复数据则跳过并存入cache新数组中返回count值等待反馈
                    \Cache::increment('offlineJobTotal'.$adminId);
                    dispatch(new ImportPolicyOfflineJob($data,$adminId,$allowUpdate));
                }
            }
        }
        if($allowUpdate != 0) {//上传到storage传入的文件，用来更新数据
            Storage::disk('public')->put('/offline/' . strtotime("now") . '.' . $extension, file_get_contents($file['file']['tmp_name']));
            \Cache::put('offlineStorageName' . $adminId, 'storage/app/public/offline/' . strtotime("now") . '.' . $extension, 10);
        }else{//走更新流程，推送队列完成后删掉文件
            unlink(base_path().'/'.\Cache::get('offlineStorageName'.$adminId));
            \Cache::forget('offlineStorageName'.$adminId);
        }
        if(\Cache::get('offlineJobTotal'.$adminId) == 0){
            return false;
        }else{
            return true;
        }
    }
}

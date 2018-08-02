<?php
/**
 * Created by PhpStorm.
 * User: wangsl
 * Date: 2017/8/10
 * Time: 10:42
 */

Route::group(['prefix' => '/channelsapi','namespace'=>'ChannelsApiControllers'],function(){
    //欢迎页面
    Route::any('/','IndexController@index');
    //企业获取授权
    Route::any('/get_account/','IndexController@getAccount');
    //预投保信息变形存库
    Route::any('/insert_prepare','ChannelInfosController@insertPrepare');
    //预投保操作
    Route::any('/do_insure_prepare','ChannelInfosController@insurePrepare');
    //测试预投保信息
    Route::any('/test_prepare','ChannelInfosController@testPrepare');
    //签约回调
    Route::any('contract_call_back', 'IndexController@contractCallBack');
    //信息回传
    Route::any('insure_out', 'ChannelInfosController@insureOut');
    //
    Route::any('do_insure_seting', 'IndexController@doInsureSeting');
    //需要验签
    Route::group(['middleware'=>'check.channels.api.sign'],function(){
        Route::any('/get_access/','IndexController@getAccess');//获取访问令牌
        Route::any('/get_prepare/','ChannelInfosController@getPrepare');//预投保信息
    });
    //需要验证sign和token
    Route::group(['middleware'=>['check.channels.api.sign','check.channels.api.token']],function(){
        //联合登录
        Route::any('/get_params/','IndexController@getParams');
        //投保支付操作
        Route::any('/get_insure/','IndexController@doInsurePay');
    });
    //需要验证access_token
    Route::group(['middleware'=>'check.channels.api.token'],function(){
        //跳转首页
        Route::any('/do_insure','IndexController@doInsure');
        Route::any('/to_insure','IndexController@toInsure');
        //获取不同的URL
        Route::any('/get_url/{name}','IndexController@getUrl');
        //页面
        Route::any('/warranty_list','IndexController@getWarranty');//保单列表
        Route::any('/warranty_info','IndexController@getWarrantyDetail');//保单详情
        Route::any('/bank_info','IndexController@getBank');//银行卡管理
        Route::any('/person_info','IndexController@getPerson');//个人信息管理
        Route::any('/insure_info','IndexController@getInsInfo');//产品详情
        Route::any('/clause_info','IndexController@getClause');//产品条款
        Route::any('/insure_notice','IndexController@insureNotice');//投保须知
        Route::any('/insure_auto_pay','IndexController@autoPay');//自动扣款声明须知
        Route::any('/insure_pay','IndexController@insurePay');//投保购买
        Route::any('/insure_sign','IndexController@insureSign');//投保签约
        Route::any('/to_insure_seting','IndexController@insureSeting');//自动投保设置
        Route::any('/insure_issue','IndexController@insureIssue');//投保出单
        //测试路由
        Route::any('/insure_test/','IndexController@testInsure');//投保测试
        Route::any('/insure_test_curl/','IndexController@insureTestCurl');//投保测试
        Route::any('/test_curl/','IndexController@multiCurl');//测试curl
        //在线理赔
        Route::any('/to_claim','IndexController@toClaim');//理赔选择
        Route::any('/claim_notice/{warranty_code}','IndexController@claimNotice');//自助理赔服务须知
        Route::any('/claim_step1/{warranty_code}','IndexController@claimStep1');//理赔第一步：填写出险人信息
        Route::any('/do_claim_step1','IndexController@doClaimStep1');//处理第一步
        Route::any('/claim_step2/{warranty_code}','IndexController@claimStep2');//理赔第二步：填写收款人账户信息
//        Route::any('/do_claim_step2','IndexController@doClaimStep2');//处理第二步
        Route::any('/claim_step3','IndexController@claimStep3');//理赔第三步：上传身份证件信息
//        Route::any('/do_claim_step3','IndexController@doClaimStep3');//处理第三步
        Route::any('/claim_step4','IndexController@claimStep4');//理赔第四步：上传理赔资料
        Route::any('/do_claim_step4','IndexController@doClaimStep4');//处理第四步
        Route::any('/claim_submit/{warranty_code}','IndexController@claimSubmit');//理赔资料提交
        Route::any('/do_claim_del','IndexController@doClaimDel');//处理理赔资料删除
        Route::any('/do_claim_submit','IndexController@doClaimSubmit');//处理理赔资料提交

        //理赔服务指南
        Route::any('/claim_apply_guide','IndexController@claimApplyGuide');//理赔操作指引
        Route::any('/claim_apply_range','IndexController@claimApplyRange');//理赔操作指引
        Route::any('/claim_apply_info','IndexController@claimApplyInfo');//理赔操作指引
        Route::any('/claim_apply_guide_index','IndexController@claimApplyGuideIndex');//理赔操作指引
        Route::any('/claim_apply_way','IndexController@claimApplyWay');//理赔操作指引
        //理赔进度/历史查询
        Route::any('/claim_records/{person_code}','IndexController@claimRecords');//理赔进度历史列表
        Route::any('/claim_info/{warranty_code}','IndexController@claimInfo');//理赔详情
        Route::any('/claim_add_material/{warranty_code}','IndexController@claimAddMaterial');//理赔资料补充
        Route::any('/do_claim_add_material','IndexController@doClaimAddMaterial');//处理理赔资料补充
        //理赔三方接口
        Route::any('/email_send','IndexController@getEmailSend');//理赔邮件
        Route::any('/sms_send','IndexController@getSmsCode');//理赔短信
    });
});

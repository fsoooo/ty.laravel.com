<?php
//test hz insurance
//Route::group(['prefix'=>'insurance','namespace'=>'\ApiControllers'], function(){
//    Route::get('ins_info', 'InsController@insInfo');
//    Route::get('show_ins', 'InsController@showIns');
//    Route::post('quote', 'InsController@quote');
//    Route::post('prepare_order', 'InsController@prepareOrder');
//
//    Route::group(['middleware'=>'guest'],function(){
//        Route::get('insure/{identification}', 'InsController@insure');
//        Route::post('insure_post', 'InsController@insurePost');
//        Route::get('pay_settlement/{order_code}', 'InsController@paySettlement');
//        Route::post('order_pay_settlement', 'InsController@orderPaySettlement');
//        Route::post('order_status', 'InsController@orderStatus');
//    });
//});
//todo test all insurance
Route::group(['prefix'=>'ins','namespace'=>'\ApiControllers'], function(){
    Route::get('ins_info/{id}', 'InsApiController@insInfo');
    Route::get('show_ins', 'InsApiController@showIns');//获取产品详情
    Route::post('quote', 'InsApiController@quote');//算费
    Route::post('prepare_order', 'InsApiController@prepareOrder');//预订单
    Route::any('health_notice/{identification}','InsApiController@healthNotice'); //跳转到健康须知
    Route::any('call_back', 'InsApiController@callBack');//回调
    Route::get('add_beibaoren/{identification}','GroupInsApiMobileController@addBeibaoren');//移动端团险投保页(添加被保人)
    Route::any('add_beibaoren_info/{identification}','GroupInsApiMobileController@addBeibaorenInfo');//移动端团险投保页(添加被保人信息)
    Route::post('add_beibaoren_info_submit','GroupInsApiMobileController@addBeibaorenInfoSubmit');//移动端团险投保页(添加被保人信息数据提交)
    Route::get('add_beibaoren_success','GroupInsApiMobileController@addBeibaorenSuccess');//移动端团险投保页(添加被保人信息成功)
    Route::post('sub_health_notice', 'InsApiController@subHealthNotice');//提交健康告知


   //TODO  wangsl2018-01.11修改（匿名下单）
    Route::get('insure/{identification}', 'InsApiController@insure'); //投保属性页
    Route::any('confirmform', 'InsApiController@confirmForm');//信息预览-个险
    Route::any('group_confirm_form', 'InsApiController@groupConfirmForm');//信息预览-团险
    Route::group(['prefix'=>'mobile_group_ins'],function(){ //移动端团险不需要登陆部分
        Route::any('insure/{identification}','GroupInsApiMobileController@insure');//移动端团险投保页(企业信息)
        Route::any('insure_mobile_company_info/{identification}','GroupInsApiMobileController@insureMobileCompanyInfo');//移动端团险投保页(员工信息)
        Route::post('delete_info/{id}','GroupInsApiMobileController@deleteInfo');//移动端团险投保页(删除员工信息)
        Route::post('edit_info/{id}','GroupInsApiMobileController@editInfo');//移动端团险投保页(修改员工信息)
        Route::post('edit_info_submit/{id}','GroupInsApiMobileController@editInfoSubmit');//移动端团险投保页(修改员工信息数据提交)
        Route::any('mobile_group_confirm_form','GroupInsApiMobileController@mobileGroupConfirmForm');//移动端团险投保页(信息确认页)
    });
    Route::group(['middleware'=>'guest'],function(){
//        Route::get('insure/{identification}', 'InsApiController@insure'); //投保属性页
        Route::get('insure2/{identification}', 'InsApiController@insure2');
//        Route::any('confirmform', 'InsApiController@confirmForm');//预览
        Route::any('insure_post', 'InsApiController@insurePost');
        Route::post('group_submit', 'InsApiController@groupSubmit');//团险移动端数据提交
        Route::get('pay_settlement/{order_code}', 'InsApiController@paySettlement');
        Route::post('order_pay_settlement', 'InsApiController@orderPaySettlement');
        Route::post('order_status', 'InsApiController@orderStatus');
        Route::post('get_pay_way_info', 'InsApiController@getPayWayInfo');
        Route::any('pay_settlement/{code}', 'InsApiController@paySettlement');
        Route::any('do_pay_settlement', 'InsApiController@doPaySettlement');//银行卡支付（悟空测试）
        Route::any('get_pay_res', 'InsApiController@getPayRes');//轮询查询状态
        Route::any('insure_clause/{identification}', 'InsApiController@insureClause');//预览
        Route::any('pay_again/{code}', 'InsApiController@payAgain');//立即支付


        //团险
        Route::group(['prefix'=>'group_ins'],function(){

            //pc团险
            Route::get('insInfo/{id}','GroupInsApiController@insInfo');//团险详情页
            Route::post('quote','GroupInsApiController@quote');//团险算费
            Route::any('prepare_order','GroupInsApiController@prepareOrder');//团险算费
            Route::any('insure/{identification}','GroupInsApiController@insure');//投保页面
            Route::any('next_insure','GroupInsApiController@nextInsure');//投保页面

            //移动端
//            Route::any('insure/{identification}','GroupInsApiMobileController@insure');//移动端团险投保页(企业信息)
//            Route::any('insure_mobile_company_info/{identification}','GroupInsApiMobileController@insureMobileCompanyInfo');//移动端团险投保页(员工信息)
//            Route::post('delete_info/{id}','GroupInsApiMobileController@deleteInfo');//移动端团险投保页(删除员工信息)
//            Route::post('edit_info/{id}','GroupInsApiMobileController@editInfo');//移动端团险投保页(修改员工信息)
//            Route::post('edit_info_submit/{id}','GroupInsApiMobileController@editInfoSubmit');//移动端团险投保页(修改员工信息数据提交)
//            Route::any('mobile_group_confirm_form','GroupInsApiMobileController@mobileGroupConfirmForm');//移动端团险投保页(信息确认页)
            Route::any('insure_post','GroupInsApiMobileController@insurePost');//移动端团险投保页(支付)
            Route::post('get_pay_way_info','GroupInsApiMobileController@getPayWayInfo');//移动端团险投保页(获取支付方式)
            Route::any('get_pay_res','GroupInsApiMobileController@getPayRes');//移动端团险投保页(获取支付结果)
        });

    });
});

//前台路由
Route::group(['prefix' => '/', 'namespace'=>'FrontendControllers'],function () {
//    Route::get('test', 'TestController@index');
//    Route::get('wk_test', 'WkTestController@index');
//    Route::get('wk_test_buy', 'WkTestController@buyIns');

    Route::group(['namespace'=>'GuestControllers'],function(){
        Route::get('test_vue','Test1Controller@testVue');
        //到出与导入excel的测试路由
        Route::get('excel/export','Test1Controller@export');
        Route::get('excel/import','Test1Controller@import');
        //excel测试路由结束
        //测试前后端分离的接口
        Route::get('test_index','Test1Controller@index');
        Route::post('test_api_ml','Test1Controller@test');
        Route::get('test_api_ml_get','Test1Controller@testGet');
        Route::get('/', 'IndexController@index');
        Route::get('/product_list', 'IndexController@productList');
        Route::get('/about', 'IndexController@about');//关于我们
        Route::get('/guide', 'IndexController@guide');//引导
        Route::get('/phone_index', 'IndexController@phoneIndex');
        Route::get('/setting', 'IndexController@getSetting');
        Route::get('login', 'LoginController@login');
        Route::get('login_person', 'LoginController@loginPerson');
        Route::get('login_company', 'LoginController@loginCompany');
        Route::post('do_login_company', 'LoginController@doLoginCompany');
        Route::post('do_login', 'LoginController@doLogin');
        Route::any('do_third_login', 'LoginController@doThirdLogin');
        Route::get('logout', 'LoginController@logOut');
        Route::get('register_front','LoginController@registerFront');//注册前的页面
        Route::get('register/{type}', 'LoginController@register');//个人注册
        Route::get('register_notice', 'LoginController@registerNotice');//注册须知
        Route::post('register_post', 'LoginController@registerPost');
        Route::post('check_exist_phone', 'LoginController@checkExistPhone');
        Route::post('phone_login', 'LoginController@doPhoneLogin');
        Route::get('findpwd', 'LoginController@findPwd');
        Route::any('dofindpwd', 'LoginController@doFindPwd');
        Route::any('do_mobile_pwd', 'LoginController@doMobilePwd');
        Route::any('doemailfindpwd/{data}', 'LoginController@doEmailFindPwd');
        Route::any('update_pwd', 'LoginController@updatePwd');
        Route::get('captcha/{tmp}', 'CaptchaController@captcha');
        Route::get('checkimagegcode', 'CaptchaController@checkImagegCode');
        Route::get('group_ins','GroupInsController@index');
        Route::get('groupInsDetail/{id}','GroupInsController@groupInsDetail');
        Route::get('groupInsForm/{id}','GroupInsController@groupInsForm');
        Route::get('groupInsNotice','GroupInsController@groupInsNotice');
        Route::any('groupInsFormSubmit','GroupInsController@groupInsFormSubmit');
        Route::any('we_chat', 'LoginController@weChat');//微信登陆

        Route::group(['prefix'=>'group_ins'],function(){
            Route::get('index','GroupInsController@index');
        });


    });
    Route::group(['namespace'=>'AgentControllers'],function(){
        Route::get('agent_login','AgentLoginController@agentLogin');//代理人登录
        Route::post('agent_do_login', 'AgentLoginController@agentDoLogin');//
        Route::get('agent_logout', 'AgentLoginController@agentLogOut');//代理人登出
        Route::get('forget_password','AgentLoginController@forgetPassword'); //代理人忘记密码
        Route::post('check_code','AgentLoginController@checkCode'); //代理人忘记密码验证验证码
        Route::get('reset_password','AgentLoginController@resetPassword'); //代理人忘记密码重设密码
        Route::post('reset_password_submit','AgentLoginController@resetPasswordSubmit'); //代理人忘记密码重设密码数据提交


    });

    //企业用户个人中心
    Route::group(['namespace'=>'CompanyControllers'],function(){

    });



    //代理人登录验证
    Route::group(['middleware'=>'agent','namespace'=>'AgentControllers'],function(){
        //代理人管理
        Route::group(['prefix' => '/agent'],function(){
            Route::get('/','AgentController@agentindex');//默认跳转页面
            Route::get('/message','AgentController@message');//默认跳转页面
            Route::get('my_cust/{type}','AgentController@getMyCust');
            Route::get('index/{type}','AgentController@getCust');
            Route::get('evolve/{code}/{cust_id}','AgentController@getEvolve');//查看联系记录
            Route::get('add_evolve/{cust_id}','AgentController@addEvolve');//跳转到添加联系记录页面
            Route::post('add_evolve_submit','AgentController@addEvolveSubmit');//提交添加联系记录表单
            Route::post('add_evolve_submit','AgentController@addEvolveSubmit');
            Route::get('add/{type}','AgentController@addCust');
            Route::post('add_cust','AgentController@addCustSubmit');
            Route::get('edit/{type}/{cust_id}','AgentController@editCust');
            Route::post('edit_cust','AgentController@editCustSubmit');
            Route::get('apply/{type}','AgentController@apply');//跳转到客户代理权申请页面
            Route::get('apply_id/{cust_id}','AgentController@applyByCustId');//直接申请页面
            Route::post('apply_submit','AgentController@applySubmit');//客户代理权申请表单提交
            Route::get('apply/record/{type}','AgentController@getApply');   //客户申请记录,用来获取不同雷星
            Route::post('is_my_cust_ajax','AgentController@isMyCustAjax');//ajax判断是否已经添加过该客户
            Route::post('del_cust','AgentController@delCust'); //ajax删除客户

            //代理人账户设置
            Route::get('account','AgentController@account');//未认证的代理人进行认证页面
            Route::get('account_approve','AgentController@accountApprove');//未认证的代理人去认证
            Route::post('account_approve_submit','AgentController@accountApproveSubmit');//未认证的代理人去认证数据提交
            Route::get('account_approve_success','AgentController@accountApproveSuccess');//未认证的代理人去认证成功
            Route::any('account_reset_password','AgentController@accountResetPassword');//代理人认证后修改密码
            Route::get('account_msg','AgentController@accountMsg');//代理人查看个人信息
            Route::any('reset_password','AgentController@resetPassword');//代理人重新设置密码
            Route::get('reset_psw','AgentController@resetPsw');//代理人重新设置密码移动端
            Route::post('check_code','AgentController@checkCode');//代理人重新设置密码移动端校验验证码
            Route::get('reset_psw_step_second','AgentController@resetPswStepSecond');//代理人重新设置密码移动端设置密码
            Route::get('reset_psw_success','AgentController@resetPswSuccess');//代理人重新设置密码移动端成功
            Route::post('mobile_check_agent','AgentController@mobileCheckAgent');//代理人重新设置密码移动端校验旧密码
            Route::post('reset_password_submit','AgentController@resetPasswordSubmit');//代理人重新设置密码
            Route::get('reset_password_success','AgentController@resetPasswordSuccess');//代理人重新设置密码成功
            Route::get('account_edit','AgentController@accountEdit');//代理人修改个人信息
            Route::post('account_edit_submit','AgentController@accountEditSubmit');//代理人修改个人信息提交
            Route::get('account_edit_success','AgentController@accountEditSuccess');//代理人修改个人信息成功

        });
        Route::group(['prefix'=>'agent_brokerage'],function(){//代理人佣金模块
            Route::get('index','AgentBrokerageController@index');//代理人佣金界面
            Route::get('rate','AgentBrokerageController@getRate');//跳转到佣金查询界面
            Route::post('get_ditch_ajax','AgentBrokerageController@getDitchByProductAjax');//前台通过产品查找可以销售的渠道
            Route::post('inquire_rate','AgentBrokerageController@inquireRateAjax');//前台通过 ajax进行佣金查询
            Route::get('brokerage_statistics','AgentBrokerageController@brokerageStatistics');//佣金管理，查看佣金
            Route::get('no_settlement_order','AgentBrokerageController@noSettlementOrder');//查询未结算的订单
        });
        Route::group(['prefix'=>'agent_task'],function(){//代理人任务模块
            Route::get('index/{time_type}','AgentTaskController@index');//代理人任务主界面
            Route::get('progress/{type}','AgentTaskController@progress');//跳转到任务进度界面
            Route::post('get_task','AgentTaskController@getTask');//获取指定时间的订单完成情况
            Route::get('other_task_list','AgentTaskController@getOtherTaskList');//获取特定任务列表

            Route::get('add_order','AgentOrderController@addOrder');   //跳转到代理人线下订单录入
            Route::post('add_order_submit','AgentOrderController@addOrderSubmit');  //线下订单录入表单提交
            Route::get('order_list','AgentOrderController@offlineOrderList');  //查看线下录入的订单
            Route::get('order_detail/{order_id}','AgentOrderController@offlineOrderDetail');  //查看线下录入的订单详情



            Route::get('add_warranty','AgentWarrantyController@addWarranty');  //跳转到代理人保单录入
            Route::post('add_warranty_submit','AgentWarrantyController@addWarrantySubmit');  //线下保单录入表单提交
            Route::get('warranty_list','AgentWarrantyController@offlineWarrantyList');  //跳转到代理人保单列表
            Route::get('warranty_detail/{warranty_id}','AgentWarrantyController@offlineWarrantyDetail');  //跳转到代理人保单详情

            Route::post('ajax/get_parameter','AgentOrderController@getParameterAjax');  //通过产品id获取产品的相关信息
            Route::post('ajax/get_order_detail','AgentWarrantyController@getOrderDetail'); //




        });
        Route::group(['prefix'=>'agent_sale'],function(){//代理人销售模块，主要包含生成网址和计划书
            Route::any('add_plan','AgentSaleController@addPlan');//代理人制作计划书
            Route::post('add_plan_submit','AgentSaleController@addPlanSubmit');//代理人制作计划书提交
            Route::post('add_cust_submit','AgentSaleController@addCustSubmit');//代理人添加用户提交
            Route::get('plan_lists','AgentSaleController@planLists');//代理人计划书列表
            Route::get('plan_detail/{id}','AgentSaleController@planDetail');//代理人计划书详情
            Route::get('plan_prospectus/{id}','AgentSaleController@planProspectus');//代理人计划书说明
            Route::post('send_url','AgentSaleController@sendUrl');//代理人发送计划书
            Route::any('agent_commission','AgentSaleController@agentCommissioin');//代理人佣金
            Route::any('agent_cust/{type}','AgentSaleController@agentCust');//代理人客户管理
            Route::any('agent_company/{type}','AgentSaleController@agentCompany');//代理人客户管理(企业)
            Route::post('agent_cust_submit','AgentSaleController@agentCustSubmit');//代理人客户管理添加客户数据提交
            Route::post('delete_personal_cust/{id}','AgentSaleController@deletePersonalCust');//代理人客户管理删除客户
            Route::post('delete_company_cust/{id}','AgentSaleController@deleteCompanyCust');//代理人客户管理删除企业客户
            Route::get('cust_details/{id}','AgentSaleController@custDetails');//客户详情
            Route::get('agent_product','AgentSaleController@agentProduct');//代理人产品
            Route::get('agent_product_detail/{id}','AgentSaleController@agentProDetail');//代理人产品详情
            Route::get('plan_change','AgentSaleController@planChange');//代理人计划书已经转化的
            Route::post('get_cust_info/{id}','AgentSaleController@getCustInfo');//代理人修改客户信息

            //线下单录入
            Route::get('offline','AgentSaleOfflineController@addOfflinePlan');//线下单页面
            Route::post('addCust','AgentSaleOfflineController@addCust');//线下单添加客户
            Route::post('uploadImage','AgentSaleOfflineController@uploadImage');//上传线下单图片
            Route::post('addProduct','AgentSaleOfflineController@addProduct');//线下单添加产品
            Route::post('offlineSubmit','AgentSaleOfflineController@addOfflineSubmit');//提交线下单
            Route::get('offlinePreview','AgentSaleOfflineController@getOfflinePreview');//线下单预览
            Route::get('offlineSuccess',function (){
                return view('frontend.agents.agent_sale_offline.offline_success');
            });//线下单预览

            Route::get('agent_need','AgentSaleController@agentNeed');//代理人需求
            Route::post('agent_need_submit','AgentSaleController@agentNeedSubmit');//代理人需求提交
            Route::get('delete_need/{id}','AgentSaleController@deleteNeed');//代理人删除需求
            Route::get('agent_need_lists','AgentSaleController@agentNeedLists');//代理人需求列表
            Route::get('agent_need_detail/{id}','AgentSaleController@agentNeedDetail');//代理人需求详情
            Route::post('agent_need_chat','AgentSaleController@agentNeedChat');//代理人需求详情聊天数据提交
            Route::get('agent_need_end/{id}','AgentSaleController@agentNeedEnd');//代理人需求详情结束需求
            Route::get('communication_base','AgentSaleController@communicationBase');//代理人pc端添加沟通记录的基础模板


            //移动端
            Route::get('search_client','AgentSaleController@searchClient');//计划书移动端客户列表
            Route::get('add_plan_company','AgentSaleController@addPlanCompany');//移动端代理人给企业制作计划书
            Route::post('add_plan_company_submit','AgentSaleController@addPlanCompanySubmit');//移动端代理人给企业制作计划书数据提交
            Route::post('cust_detail/{id}','AgentSaleController@custDetail');//用户信息移动端
            Route::get('search_product','AgentSaleController@searchProduct');//移动端产品列表
            Route::post('product_detail/{id}','AgentSaleController@agentProductDetail');//移动端产品详情
            Route::get('make_add','AgentSaleController@makeAdd');//移动端添加客户
            Route::post('make_add_submit','AgentSaleController@custAddSubmit');//移动端添加客户提交数据
            Route::get('make_add_other','AgentSaleController@makeAddOther');//移动端添加客户被保人非本人
            Route::post('make_add_other_submit','AgentSaleController@makeAddOtherSubmit');//移动端添加客户被保人非本人数据提交
            Route::get('user','AgentSaleController@user');//移动端计划书个人中心
            Route::get('agent_message','AgentSaleController@agentMessage');//代理人消息
            Route::get('agent_info','AgentSaleController@agentInfo');//移动端代理人消息-通知
            Route::post('agent_info_delete','AgentSaleController@agentInfoDelete');//移动端代理人消息-通知删除
            Route::post('change_info_status','AgentSaleController@changeInfoStatus');//移动端代理人消息-通知标记已读
            Route::get('agent_info_detail/{id}','AgentSaleController@agentInfoDetail');//移动端代理人消息-通知详情
            Route::get('agent_info_looked/{id}','AgentSaleController@agentInfoLooked');//代理人消息-pc端查看改状态
            Route::get('agent_info_delete_one/{id}','AgentSaleController@agentInfoDeleteOne');//代理人消息-pc端查看改状态
            Route::get('demand','AgentSaleController@demand');//移动端我的需求
            Route::get('workorder','AgentSaleController@workorder');//移动端我的工单
            Route::get('delete_work_list/{id}','AgentSaleController@deleteWorkList');//删除我的工单
            Route::get('work_detail/{id}','AgentSaleController@workDetail');//详情页面
            Route::any('end_work_list','AgentSaleController@endWorkList');//结束我的工单
            Route::any('reply_list','AgentSaleController@replyList');//回复我的工单
            Route::any('add_reply','AgentSaleController@addReply');//回复我的工单
            Route::get('recipients','AgentSaleController@recipients');//移动端收件人
            Route::get('subordinateModule','AgentSaleController@subordinateModule');//移动端所属模块
            Route::get('addSuccess','AgentSaleController@addSuccess');//移动端所属模块
            Route::post('demand_add','AgentSaleController@demandAdd');//移动端所属模块
            Route::get('user_detail','AgentSaleController@userDetail');//移动端计划书个人中心详情
            Route::any('cust_lists','AgentSaleController@custLists');//移动端客户列表
            Route::get('mobile_cust_detail/{id}','AgentSaleController@mobileCustDetail');//移动端客户详情
            Route::get('mobile_cust_detail_other/{id}','AgentSaleController@mobileCustDetailOther');//移动端客户详情资料
            Route::get('delete_cust/{id}','AgentSaleController@deleteCust');//移动端删除客户
            Route::get('edit_cust/{id}','AgentSaleController@editCust');//移动端编辑客户
            Route::post('edit_cust_submit','AgentSaleController@editCustSubmit');//移动端编辑客户数据提交
            Route::get('client_add_person','AgentSaleController@clientAddPerson');//移动端添加客户(个人)
            Route::get('success_add_person','AgentSaleController@successClientAddPerson');//移动端添加客户(个人)成功
            Route::post('client_add_person_submit','AgentSaleController@clientAddPersonSubmit');//移动端添加客户数据提交
            Route::post('client_add_company_submit','AgentSaleController@clientAddCompanySubmit');//移动端添加客户(企业)数据提交
            Route::get('client_add_company','AgentSaleController@clientAddCompany');//移动端添加客户(企业)
            Route::get('agent_performance','AgentSaleController@agentPerformance');//移动端代理人业绩
            Route::get('agent_invite','AgentSaleController@agentInvite');//移动端代理人邀请客户
            Route::get('agent_invite_success','AgentSaleController@agentInviteSuccess');//移动端代理人邀请客户成功页面
            Route::get('cust_info','AgentSaleController@custInfo');//移动端代理人邀请客户（客户看到的界面）
            Route::post('cust_info_submit','AgentSaleController@custInfoSubmit');//移动端邀请客户（客户看到的页面数据提交）
            Route::get('cust_info_submit_success','AgentSaleController@custInfoSubmitSuccess');//移动端邀请客户（客户看到的页面数据提交）成功
            Route::get('plan_detail_other/{id}','AgentSaleController@planDetailOther');//移动端计划书列表点击查看详情后进入的页面
            Route::get('agent_order','AgentSaleController@agentOrder');//移动端代理人的订单
            Route::get('cust_order_detail/{id}','AgentSaleController@custOrderDetail');//移动端代理人查看客户的订单详情
            Route::get('communication','AgentSaleController@communication');//代理人添加沟通记录
            Route::get('communication_add','AgentSaleController@communicationAdd');//代理人添加沟通记录添加
            Route::post('communication_add_submit','AgentSaleController@communicationAddSubmit');//代理人添加沟通记录添加数据提交
            Route::get('communication_add_client','AgentSaleController@communicationAddClient');//代理人添加沟通记录手动添加
            Route::post('communication_add_client_submit','AgentSaleController@communicationAddClientSubmit');//代理人添加沟通记录手动添加数据提交
            Route::get('communication_delete','AgentSaleController@communicationDelete');//代理人删除沟通记录



            //旧
//            Route::get('product_detail/{product_id}','AgentSaleController@getProductDetail');//查看产品详情
//            Route::get('product_list','AgentSaleController@getProduct');//查看所有的可售产品
//            Route::get('create_url/{product_id}','AgentSaleController@createUrl');//跳转到生成网址页面
//            Route::post('create_url_submit','AgentSaleController@createUrlSubmit');//生成网址表单提交
//            Route::get('plan','AgentSaleController@plan');//跳转到计划书页面
//            Route::get('create_plan/{product_id}','AgentSaleController@createPlan');//跳转到创建计划书界面
//            Route::get('create_plan','AgentSaleController@plan');//跳转到创建计划书界面
//            Route::get('my_plan','AgentSaleController@getMyPlan');//获取自己的计划书
//            Route::post('plan_submit','AgentSaleController@planSubmit');//计划书表单提交页面
        });







    });
    //需要登录
    Route::group(['middleware'=>'guest','namespace'=>'GuestControllers'], function(){
        Route::get('home','UserController@index');   //用户中心首页
        Route::group(['prefix' => '/claim'],function () {
            Route::get('index', 'ClaimController@index');
            Route::get('claim/{id}', 'ClaimController@claim');//填写保单页面
            Route::post('submit', 'ClaimController@submit');//保全表单提交
            Route::get('detail/{did}','ClaimController@getClaimDetail');
            Route::get('detail_local/{did}','ClaimController@getClaimLocalDetail');
            Route::get('get_claim','ClaimController@getClaimList'); //查看理赔列表
            Route::get('evolve','ClaimController@getEvolve');
            Route::post('upload_img','ClaimController@uploadImg');//理赔图片上传
        });
        Route::group(['prefix' => '/message'],function () {
            Route::get('index', 'MessageController@index');//信息首页
            Route::get('detail/{id}', 'MessageController@detail');//信息详情页
            Route::post('delete', 'MessageController@delete');//信息删除
            Route::get('delete_one/{id}', 'MessageController@deleteOne');//信息删除-单条
            Route::post('looked', 'MessageController@looked');//信息标记已读
            Route::get('get_all', 'MessageController@getAllMessage');
            Route::get('get_unread','MessageController@getUnreadMessage');
            Route::get('get_detail/{id}','MessageController@getMessageDetail');
            Route::get('send','MessageController@send');
            Route::get('get_read','MessageController@getReadMessage');
            Route::post('get_my_message','MessageController@getMyMessage');
            Route::post('send_message', 'MessageController@submit');
        });
        //个人信息管理
        Route::group(['prefix'=>'information'],function(){
            Route::get('/','InformationController@indexinfo');//客户信息查看
            Route::post('modification','InformationController@modification');//客户信息查看
            Route::get('guest_info','InformationController@guestInfo');//客户信息查看
            Route::any('groupChangeSubmit','InformationController@groupChangeSubmit');//组织信息修改
            Route::get('change_information','InformationController@changeInformation');//跳转到修改信息
            Route::post('change_information_submit','InformationController@changeInformationSubmit');//修改信息表单提交
            Route::get('home_page','InformationController@home_page');//跳转到修改密码
            Route::any('phone_check','InformationController@phoneCheck');//手机号验证
            Route::get('change_password','InformationController@changePassword');//跳转到修改密码
            Route::get('proving_code','InformationController@proving_code');
            Route::post('change_password_submit','InformationController@changePasswordSubmit');//修改密码表单提交
            Route::get('profile','InformationController@profile');  //跳转到完善个人信息页面
            Route::post('profile_submit','InformationController@profileSubmit');   //完善个人信息页面提交
            Route::any('invoice','InformationController@invoice');   //发票管理
            Route::any('authentication','InformationController@authentication');   //公司认证管理
            Route::get('channels_index','InformationController@channelsIndex');   //多渠道用户登录管理
            Route::any('test','InformationController@upload');
            Route::get('real_name_certification','InformationController@realNameCertification');   //多渠道用户登录管理
            Route::get('approvePerson','InformationController@approvePerson');   //多渠道用户登录管理
            Route::post('real_name','InformationController@real_name');   //个人用户提交认证数据
            Route::post('company_submit','InformationController@company_submit');   //企业用户用户提交认证数据
            Route::post('changePass','InformationController@changePass');   //企业用户修改密码提交认证数据
            Route::get('datas','InformationController@datas');   //企业用户数据统计
            Route::get('payment','InformationController@payment');   //企业用户数据统计详情页
            Route::get('dataManage','InformationController@dataManage');   // （数据管理） 总人数、理赔详情
            Route::get('staffManage','InformationController@staffManage');   //（保障与人元管理）增员、减员详情
        });
        //订单管理
        Route::group(['prefix'=>'order'],function(){
            Route::get('index/{type}','OrderController@index');//列出个人客户的各种保单
            Route::get('detail/{order_id}','OrderController@getOrderDetail');//获取保单的详细信息
            Route::get('detail_recognizee/{order_id}','OrderController@getOrderDetailRecognizee');//获取保单的详细信息被保人列表
            Route::get('detail_recognizee_add/{id}','OrderController@detailRecognizeeAdd');//获取保单的详细信息被保人列表添加人
            Route::post('detail_recognizee_add_submit','OrderController@detailRecognizeeAddSubmit');//获取保单的详细信息被保人列表添加人
            Route::get('recognizee_add_submit_success','OrderController@detailRecognizeeAddSubmitSuccess');//获取保单的详细信息被保人列表添加人
            Route::post('change_policy','OrderController@changePolicy');//修改投保人信息
            Route::post('change_policy_submit','OrderController@changePolicySubmit');//投保人信息表单提交
            Route::get('add_recognizee/{order_id}','OrderController@addRecognizee');//跳转到添加页面
            Route::post('add_recognizee_submit','OrderController@addRecognizeeSubmit');//添加受保人表单提交
            Route::get('change_recognizee/{recognizee_id}','OrderController@changeRecognizee');//跳转到修改被保人信息界面
            Route::post('change_recognizee_submit','OrderController@changeRecognizeeSubmit');//被保人信息表单提交
            Route::get('del_recognizee/{order_id}/{recognizee_id}','OrderController@delRecognizee');//删除被保人
            Route::get('change_premium/{order_code}','OrderController@changePremium');//跳转到添加保额界面
            Route::post('change_premium_submit','OrderController@changePremiumSubmit');//保额表单提交
            Route::get('cancel_order/{order_id}','OrderController@cancelOrder');//跳转到退保界面
            Route::any('cancel_order_submit','OrderController@cancelOrderSubmit');//退保表单提交
            Route::any('check_phone','OrderController@checkPhone');//验证手机，变更页面
            Route::any('change_submit','OrderController@changeSubmit');//变更展示
            Route::any('submit_change','OrderController@submitChange');//变更提交
            Route::get('pay_again/{code}','OrderController@payAgain');//未支付的订单去支付（9.12）

        });
        //保单管理
        Route::group(['prefix'=>'guarantee'],function(){
            Route::get('index/{type}','SlipController@index');//保单显示页面
            Route::get('detail/{id}','SlipController@detail');//保单详情
            Route::get('change/{order_id}','SlipController@change');//保单显示页面
            Route::get('guarantee_detail/{id}','SlipController@guaranteeDetail');//移动端个人保单详情
//            Route::get('company_guarantee/{type}','OrderController@companyGuarantee');//pc端公司保单
            Route::get('company_guarantee_detail/{id}','OrderController@companyGuaranteeDetail');//pc端公司保单详情

        });
        //保全业务
        Route::group(['prefix'=>'preservation'],function(){
            Route::any('insure_cacel/{warranty_code}','PreservationController@insureCacel');//退保操作
        });


        //移动端个人中心
        Route::group(['prefix'=>'mpersonal'],function(){
            Route::get('manage','MpersonalController@manage');//个人中心账户管理
            Route::get('contact','MpersonalController@contact');//个人中心账户管理常用联系人
            Route::get('addperson','MpersonalController@addPerson');//个人中心账户管理常用联系人加人
            Route::post('addsubmit','MpersonalController@addSubmit');//个人中心账户管理常用联系人加人数据提交
            Route::get('chang_psw','MpersonalController@changePsw');//个人中心账户管理跳转到修改密码
            Route::get('info','MpersonalController@info');//个人中心账户管理跳转到个人信息
            Route::post('info_submit','MpersonalController@infoSubmit');//个人中心账户管理个人信息提交
            Route::get('order_detail/{code}','MpersonalController@orderDetail');//个人中心订单详情
            Route::get('not_found','MpersonalController@notFound');//404
        });
        //移动端企业中心
        Route::group(['prefix'=>'cpersonal'],function(){
            Route::get('approve_company','CpersonalController@approveCompany');//企业认证
            Route::post('approve_submit','CpersonalController@approveSubmit');//企业认证提交
            Route::get('staff/{status}','CpersonalController@staff');//企业员工管理
            Route::post('staff_delete/{id}','CpersonalController@delete');//企业员工管理(删除)
            Route::get('staffadd','CpersonalController@staffAdd');//企业员工添加
            Route::post('staffaddsubmit','CpersonalController@staffAddSubmit');//企业员工添加提交
            Route::get('datas','CpersonalController@datas');//企业数据统计
        });

        //需求工单管理
        Route::group(['prefix'=>'liability_demand'],function(){
            Route::get('index','LiabilityDemandController@index');//添加责任需求页面
            Route::post('get_traiff','LiabilityDemandController@getTraiffByClauseId');//通过责任查找公司的参数


            Route::post('add_demand_submit','LiabilityDemandController@addDemandSubmit');//需求表单提交页面
            Route::get('my_demand/{type}','LiabilityDemandController@getMyDemand');//跳转到我的需求界面
        });

        //企业员工管理
        Route::group(['prefix'=>'staff'],function(){
            Route::get('index/{type}','StaffController@index');//员工管理首页
            Route::get('get_url/{id}','StaffController@getUrl');//员工新增获取下载模板
            Route::post('newlyStaff','StaffController@newlyStaff');//员工新增
            Route::post('editStaff','StaffController@editStaff');//员工编辑
            Route::post('edit_person/{id}','StaffController@editPerson');//员工编辑获取数据
            Route::get('passStaff/{id}','StaffController@passStaff');//员工删除
            Route::get('delStaff/{id}','StaffController@delStaff');//刚添加的员工删除
        });

        //需求页面详情战士
        Route::group(['prefix'=>'demand'],function(){
            Route::get('/{demand_code}','DemandController@index');//跳转到需求列表页面
            Route::get('/{demand_code}/{id}','DemandController@demandDetail');//跳转到需求详细页面
        });
        //保全管理
        Route::group(['prefix'=>'/maintenance'],function(){//保全管理
            Route::get('index','MaintenanceController@index');//保全管理主页面
            Route::get('change_data','MaintenanceController@changeData'); //投保人变动
            Route::get('index/{type}','MaintenanceController@index');//跳转到保全的默认界面
            Route::get('change_data/{type}','MaintenanceController@changeData');//跳转到资料变更页面
            Route::get('change_data_list/{id}','MaintenanceController@getChangeData');//获取某个客户的所有基本信息修改记录
            Route::get('change_person_list/{id}','MaintenanceController@changePersonData');//获取单个保单的所有人员变动情况
            Route::get('agree_change_person/{change_type}/{product_id}','MaintenanceController@agreeChangePerson');//修改人员
            Route::get('change_insurance/{type}','MaintenanceController@changeInsurance');//跳转到保额修改界面
            Route::post('get_person_change','MaintenanceController@getPersonChangeByTime');//通过时间段查询企业保单人员变更
            Route::get('change_recognizee','MaintenanceController@changeRecognizee');//被保人资料修改
            Route::get('change_person','MaintenanceController@changePerson');//团险人员变更
            Route::get('cancel','MaintenanceController@cancel');//退保申请列表
            Route::get('cancel_detail/{order_id}','MaintenanceController@cancelDetail');//退保申请详情
            Route::get('change_premium','MaintenanceController@changePremium');//跳转到保额修改界面
            Route::get('change_premium_detail/{order_list}','MaintenanceController@changePremiumDetail');//修改保额详情
            Route::get('change_data_detail/{order_list}','MaintenanceController@changeDataDetail');//修改保额详情

        });

        //保单管理
        Route::group(['prefix'=>'warranty'],function(){
            Route::get('index/{type}','WarrantyController@index');//列出个人客户的所有保单
            Route::get('detail/{warranty_id}','WarrantyController@getWarrantyDetail');//获取保单的详细信息
            Route::get('change_policy','WarrantyController@changePolicy');//修改投保人信息
            Route::get('add_recognizee/{warranty_id}','WarrantyController@addRecognizee');//跳转到添加页面
            Route::post('add_recognizee_submit','WarrantyController@addRecognizeeSubmit');//添加受保人表单提交
            Route::get('del_recognizee/{order_id}/{recognizee_id}','WarrantyController@delWarranty');//删除被保人
            Route::get('change_premium/{order_id}','WarrantyController@changePremium');//跳转到修改保额界面
//            Route::get('change_premium_submit','')

        });


        //产品详情页到购买
        Route::group(['prefix'=>'product'],function(){
            Route::get('insure/{identification}','ProductController@insure'); //完善投保人和被保人信信息
            Route::post('insure_submit','ProductController@insureSubmit');   //完善信息提交,并跳转到支付界面
            Route::get('addforms','ProductController@addForms');
            Route::any('confirmform','ProductController@confirmform');
            Route::any('group/confirm_form','ProductController@groupConfirmForm');
            Route::get('order_pay/{order_code}','ProductController@order_pay');   //跳转到支付界面
            Route::any('group_order_pay/{order_code}/{product_id}','ProductController@group_order_pay');   //跳转到团险支付界面
            Route::get('pay_settlement/{union_Order_code}','ProductController@paySettlement');
            Route::post('insurance_submit/{identification}','ProductController@insureSubmit');  //产品购买参数补全
            Route::any('order_pay_settlement','ProductController@orderPaySettlement');   //订单支付处理
            Route::any('order_pay_success/{order_code?}','ProductController@orderPaySuccess');   //订单支付成功
            Route::any('save_bank','ProductController@saveBank');   //保存银行卡信息

        });
        Route::group(['namespace'=>'GuestControllers'],function(){
//            Route::any('productlists/{code}', 'ProductController@productLists');//列表
//            Route::any('productinfo/{code}', 'ProductController@productInfo');//产品详情
//            Route::any('makeorder', 'ProductController@makeOrder');//生成订单
//            Route::any('selecttariff', 'ProductController@selectTariff');//匹配费率
//            Route::any('checkage', 'ProductController@checkAge');//匹配年龄
            Route::any('saveforminfo', 'ProductController@saveFormInfo');//保存投保信息
            Route::any('toorder', 'ProductController@toOrder');//完善投保信息

        });


    });
//前台产品展示
    Route::group(['namespace'=>'GuestControllers'],function(){
        Route::any('productlists/{code}', 'ProductController@productLists');//列表
        Route::any('productinfo/{code}', 'ProductController@productInfo');//产品详情
        Route::any('makeorder', 'ProductController@makeOrder');//生成订单
        Route::any('selecttariff', 'ProductController@selectTariff');//匹配费率
        Route::any('checkage', 'ProductController@checkAge');//匹配年龄
        Route::any('saveforminfo', 'ProductController@saveFormInfo');//保存投保信息
        Route::any('toorder', 'ProductController@toOrder');//完善投保信息
        Route::get('cust_plan/{id}','CustPlanController@custPlan');//客户打开计划书
        Route::post('evaluate_submit','CustPlanController@evaluateSubmit');//客户打开计划书

        //二维码加人路由组
        Route::group(['prefix'=>'qrCode'],function(){
            Route::any('index','QrCodeController@index');
        });

    });
    Route::group(['prefix'=>'product','namespace'=>'GuestControllers'],function(){
        Route::any('prepare_order','ProductController@prepareOrder'); //跳转到预购
        Route::any('health_notice/{identification}','ProductController@healthNotice'); //跳转到健康须知
        Route::get('insure_clause','ProductController@insureClause');
    });



//
//    Route::any('product_lists/{label_id}', 'ProductController@productLists');//按产品分类查找产品列表
//    Route::any('product_info/{product_id}', 'ProductController@productInfo');//查看产品详情
//    Route::post('prepare_parmeter','ProductController@prepareOrder');//预填写订单
//    Route::get('insure/{identification}','ProductController@insureOrder');//完善订单，添加投保人和被保人信息
//    Route::post('insure_submit','ProductController@insuranceSubmit');//完善订单信息,

});


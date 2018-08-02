<?php
//后台路由
Route::group(['prefix' => '/backend', 'namespace'=>'BackendControllers'],function () {


    //需要登录
    Route::group(['middleware'=>'admin.login:admin'], function(){
        Route::get('/', 'IndexController@index');
        Route::get('statistics', 'IndexController@statistics');
        Route::get('indexTask', 'IndexController@indexTask');
        Route::get('average', 'IndexController@average');
        Route::get('agentCount', 'IndexController@agentCount');
        Route::get('brokerage', 'IndexController@brokerage');
        Route::get('ranking', 'IndexController@ranking');
        Route::get('customer', 'IndexController@customer');
        Route::get('safe', 'IndexController@safe');
        Route::get('PieChart', 'IndexController@PieChart');

        //所属者路由组
        Route::group(['prefix'=>'boss','middleware'=>['owner.role:admin']], function(){
            //老板统计
            Route::group(['prefix'=>'business'],function(){
                Route::get('index','BossBusinessController@order');//老板业务统计
                Route::get('cust/{type}','BossBusinessController@cust');//客户统计
                Route::any('get_order_detail','BossBusinessController@get_order_detail');
//                Route::get('warrabtt',)
            });
            //佣金统计
            Route::group(['prefix'=>'brokerage'],function(){
                Route::get('index/{id}','BossBrokerageController@index');//中介公司老板佣金统计
                Route::get('record','BossBrokerageController@record');//中介公司老板查看佣金体现记录
            });
            //产品统计
            Route::group(['prefix'=>'product'],function(){
                Route::get('index/{type}','BossProductController@index');//产品统计,获取所有的产品
                Route::get('detail/{product_id}','BossProductController@getDetail');//获取产品的详情

            });
            //销售统计
            Route::group(['prefix'=>'sale'],function(){
                Route::get('index/{period}','BossSaleController@index');//销售统计
                Route::get('details/{name}','BossSaleController@details');//销售详情
            });
            //客户统计
            Route::group(['prefix'=>'cust'],function(){
               Route::get('index/{type}','BossCustController@index');//添加客户统计列表
                Route::get('register','BossCustController@register');//注册客户统计列表

            });
            //代理人统计
            Route::group(['prefix'=>'agent'],function(){
                Route::get('index/{data}','BossBusinessController@agent');//代理人统计
                Route::get('detail/{id}','BossBusinessController@detail');//代理人业绩详情
                Route::get('screen','BossBusinessController@screen');//代理人业绩详情
            });
        });

        //admin权限路由组
        Route::group(['prefix'=>'role', 'middleware'=>['admin.role:admin']],function(){
            //权限管理
            Route::get("roles","RoleController@roles"); //角色列表
            Route::get("permissions","RoleController@permissions"); //权限列表
            Route::post("post_add_role","RoleController@addRolePost"); //添加角色
            Route::get("omitRole","RoleController@omitRole"); //删除角色
            Route::post("modify","RoleController@modify"); //修改角色
            Route::post("post_add_permission","RoleController@addPermissionPost"); //添加权限
            Route::get("omitpower","RoleController@omitpower"); //删除权限
            Route::post("modifypower","RoleController@modifypower"); //修改权限
            //角色与权限
            Route::get('role_bind_permission',"RoleController@roleBindPermission"); //角色权限查看
            Route::post('role_find_permissions',"RoleController@roleFindPermissions"); //根据角色找权限
            Route::post('attach_permissions',"RoleController@attachPermissions"); //角色权限绑定
            //用户与角色
            Route::get('user_bind_roles',"RoleController@userBindRoles"); //用户角色查看
            Route::post('user_find_roles',"RoleController@userFindRoles"); //根据用户找角色
            Route::post('attach_roles',"RoleController@attachRoles"); //用户角色绑定
        });

        //业管人员路由组
        Route::group(['middleware'=>['worker.role:admin']], function(){
            //发票管理
            Route::group(['prefix'=>'invoice'],function(){
               Route::any('index','InvoiceController@index');
               Route::any('submit','InvoiceController@invoiceSubmit');
            });

            //公司认证管理
            Route::group(['prefix'=>'authentication'],function(){
                Route::any('index/{parameter}','AuthenticationController@index');
                Route::any('deal/{id}','AuthenticationController@deal');
                Route::any('submit/{id}','AuthenticationController@submit');
                Route::any('approvePerson','AuthenticationController@approvePerson');       //个人认证
                Route::any('dealPerson/{id}','AuthenticationController@dealPerson');       //个人认证处理
                Route::any('dealPersonSubmit/{id}','AuthenticationController@dealPersonSubmit');       //个人认证处理

            });

            //销售管理
            Route::group(['prefix'=>'sell'],function(){
                //渠道代理人
                Route::group(['prefix'=>'ditch_agent'],function(){
                    Route::get('channel','DitchAgentController@channel'); //渠道管理
                    Route::get('channel_details','DitchAgentController@channel_details'); // //渠道详情
                    Route::get('add_channel','DitchAgentController@add_channel'); // 添加渠道
                    Route::get('set_brokerage','DitchAgentController@set_brokerage'); // 佣金设置
                    Route::get('list_brokerage','DitchAgentController@list_brokerage'); // 封装佣金展示
                    Route::get('agent_brokerage','DitchAgentController@agent_brokerage'); // 代理人佣金展示
                    Route::get('agent_brokerage_addition','DitchAgentController@agent_brokerage_addition'); // 代理人佣金添加
                    Route::get('active_brokerage','DitchAgentController@active_brokerage'); // 活跃产品佣金的展示
                    Route::get('active_brokerage_add','DitchAgentController@active_brokerage_add'); // 活跃产品佣金的添加
                    Route::get('add_brokerage','DitchAgentController@add_brokerage'); // 佣金添加
                    Route::get('channel_record','DitchAgentController@channel_record'); //销售记录
                    Route::get('channel_agent','DitchAgentController@channel_agent'); //渠道代理人
                    Route::get('channel_active','DitchAgentController@channel_active'); //活跃产品
                    Route::get('channel_task','DitchAgentController@channel_task'); //渠道任务

                    Route::delete('ditch/delete/{id}','DitchAgentController@deleteDitch'); //渠道列表
                    Route::get('ditch/details/{id}','DitchAgentController@details'); //渠道详情
                    Route::get('agents/{id}','DitchAgentController@agents'); //代理人列表
                    Route::get('active_products/{id}','DitchAgentController@active_products'); //活跃产品
                    Route::get('product_details/{id}','DitchAgentController@product_details'); //活跃产品详情
//                    Route::get('achievement/{id}','DitchAgentController@achievement'); //渠道业绩统计
//                    Route::get('ranking/{id}','DitchAgentController@ranking'); //渠道代理人销量
//                    Route::get('agents/create','DitchAgentController@createAgent'); //创建代理人
//                    Route::get('agents/edit/{id}','DitchAgentController@editAgent'); //修改代理人
//                    Route::post("post_add_ditch","DitchAgentController@addDitchPost"); //添加渠道
//                    Route::post("post_add_agent","DitchAgentController@addAgentPost"); //添加代理人
//                    Route::put("update_agent/{id}","DitchAgentController@updateAgent"); //添加代理人
//                    //渠道代理关联
//                    Route::get('ditch_bind_agent',"DitchAgentController@ditchBindAgent"); //渠道代理人查看
//                    Route::post('ditch_find_agent',"DitchAgentController@ditchFindAgent"); //根据渠道找代理人
//                    Route::post('attach_agents',"DitchAgentController@attachAgents"); //渠道代理人绑定
//                    //佣金设置
//                    Route::get('brokerage','DitchAgentController@brokerage');//销售佣金设置页面
//                    Route::post('search_product','DitchAgentController@searchProductById');//搜索产品,并重定向到产品详情页面
//                    Route::get('brokerage_detail/{product_id}','DitchAgentController@brokerageDetail');//产品详情页面
//                    Route::post('set_brokerage','DitchAgentController@setBrokerage');//设置产品佣金，
//                    Route::post('get_product_ajax','DitchAgentController@getProductAjax');//根据产品id获取产品

                });
            });
            //代理人管理
            Route::group(['prefix'=>'agent'], function() {
                Route::get('list', 'AgentController@index');
                Route::post('add_agent_post', 'AgentController@addAgentPost');
                Route::get('agent_info/{id}', 'AgentController@agentInfo')->where('id','[0-9]+');   //todo   详情
//                Route::post('update_agent_post', 'AgentController@addAgentPost');   //todo 提交修改
                Route::get('performance/{id}', 'AgentController@performance');
                Route::get('clients/{id}', 'AgentController@clients');
                Route::get('products/{id}', 'AgentController@products');
                Route::get('plans/{id}', 'AgentController@plans');
                Route::get('plan/{id}', 'AgentController@plan');
                Route::post('add_ditch', 'AgentController@addDitch');
                Route::get('true_info/{id}', 'AgentController@trueInfo');
                Route::post('dispose_audit', 'AgentController@disposeAudit');
                Route::post('change_work_status', 'AgentController@changeWorkStatus');
            });
            //佣金管理
            Route::group(['prefix'=>'set_brokerage'], function(){
                Route::get('list', 'BrokerageController@index');
                Route::post('set_brokerage_post', 'BrokerageController@setBrokeragePost');
                Route::get('agent_brokerage', 'BrokerageController@agentBrokerage');
            });
            //客户管理
            //关系管理后台
//            Route::group(['prefix'=>'/relation'],function(){
//                Route::get("cust/{type}","CustController@index");
//                Route::get('type/{type}','CustController@getCustByType');
//                Route::get("getallcust","CustController@getAllCust");
//                Route::get('edit_cust/{type}/{id}','CustController@editCust');//跳转到更新信息
//                Route::get('add_cust/{type}','CustController@addCust');//跳转到添加客户
//                Route::get("get_apply","CustController@getApply");
//                Route::get('get_deal_apply','CustController@getDealApply');
//                Route::get('agree_apply/{record_id}','CustController@agreeApply');
//                Route::get('refuse_apply/{apply_id}','CustController@refuseApply');
//                Route::post("add_cust_submit","CustController@addCustSubmit");
//                Route::post('edit_cust_submit','CustController@editCustSubmit');//修改客户信息表单提交
//                Route::get('evolve/{code}/{cust_id}','CustController@getEvolve');//查看联系记录
//                Route::get('distribute/{type}/{cust_id}','CustController@distribute');//跳转到分配客户页面
//                Route::post('is_distribution_ajax','CustController@isDistributionAjax');//ajax判断客户是否被分配
//                Route::post('is_my_cust_ajax','CustController@isMyCustAjax');//ajax判断是否已经添加过该客户
//                Route::get('distribute_cust/{code}/{agent_id}','CustController@distributeCust'); //分配客户
//                Route::post('del_cust','CustController@delCust');//删除客户,软删
////                Route::post('')
//            });

            //保全管理
//            Route::group(['prefix'=>'maintenance'],function(){//保全管理
//                Route::get('index/{type}','MaintenanceController@index');//跳转到保全的默认界面
//                Route::get('change_data/{type}','MaintenanceController@changeData');//跳转到资料变更页面
//                Route::get('change_data_list/{id}','MaintenanceController@getChangeData');//获取某个客户的所有基本信息修改记录
//                Route::get('change_person_list/{id}','MaintenanceController@changePersonData');//获取单个保单的所有人员变动情况
//                Route::get('agree_change_person/{change_type}/{product_id}','MaintenanceController@agreeChangePerson');//修改人员
//                Route::get('change_insurance/{type}','MaintenanceController@changeInsurance');//跳转到保额修改界面
//                Route::post('get_person_change','MaintenanceController@getPersonChangeByTime');//通过时间段查询企业保单人员变更
//                Route::get('change_recognizee','MaintenanceController@changeRecognizee');//被保人资料修改
//                Route::get('change_person','MaintenanceController@changePerson');//团险人员变更
//                Route::get('cancel','MaintenanceController@cancel');//退保申请列表
//                Route::get('cancel_detail/{order_id}','MaintenanceController@cancelDetail');//退保申请详情
//                Route::get('change_premium','MaintenanceController@changePremium');//跳转到保额修改界面
//                Route::get('change_premium_detail/{order_list}','MaintenanceController@changePremiumDetail');
//                Route::get('change_data_detail/{union_order_code}','MaintenanceController@changeDataDetail');//变更详情
//                Route::get('change_data_submit/{union_order_code}','MaintenanceController@changeDataSubmit');//提交变更
//
////                Route::post('send_mail/{order_id}','MaintenanceController@sendMail');//调用接口，向保险公司发送邮件
////                Route::post('change_pre')
//           });
            //退保管理
//            Route::group(['prefix'=>'/cancel'],function(){
//                Route::get('/{type}','CancelController@index'); // 根据退保类型获取退保列表
//                Route::get('/cancel_detail/{id}','CancelController@cancelDetail');  //获取退保详情
//            });


            //理赔后台
//            Route::group(['prefix'=>'/claim'],function(){
//                Route::get('index','ClaimController@index');
//                Route::get('get_claim/{type}','ClaimController@getClaim');//根据类型获取理赔列表
//                Route::get('get_detail/{id}','ClaimController@getClaimDetail');
//                Route::post('add_record','ClaimController@addRecord');
//                Route::get('operation/{cid}','ClaimController@operation');
//                Route::get('get_record/{cid}','ClaimController@getRecord');
//            });
            //消息后台
            Route::group(['prefix'=>'/sms'],function(){
                Route::any("message","MessageController@index");
                Route::post("msg_submit","MessageController@msgSubmit");
                Route::get("msg_detail/{id}","MessageController@msgDetail");
                Route::any("search","MessageController@search");
                Route::get('has_send','MessageController@getSend');
                Route::get('message_mould','MessageController@messageMould');//站内信模板
                Route::post('send_message','MessageController@sendMessage');
                Route::get('get_detail/{id}','MessageController@getDetail');//查看站内信的详情

                //信息管理
                Route::get('email','MassageController@email');//邮件
                Route::get('mail','MassageController@mail');//站内信
                Route::get('sms','MassageController@sms');//短信
                Route::get('smsinfo','MassageController@smsInfo');
                Route::get('smsinfolist','MassageController@smsInfoList');
                Route::get('smslistinfo','MassageController@smsListInfo');
                Route::get('savetoken','MassageController@saveToken');//保存token
                Route::get('test','MassageController@test');//改变状态
                Route::get('changestatus','MassageController@changeStatus');//test
                Route::any('hassendemail','MassageController@hasSendEmail');//已发送邮件
                Route::any('emailmodels','MassageController@emailModels');//邮件模板
                Route::any('addemailmodels','MassageController@addEmailModels');//添加邮件模板
                Route::any('doaddmodels','MassageController@doAddEmailModels');//处理添加模板
                Route::any('getemailmodels','MassageController@getEmailModels');//获取模板
                Route::any('emailmodelsinfo','MassageController@emailModelsInfo');//查看模板详情
                Route::any('hasemailinfo','MassageController@hasEmailInfo');//查看已发邮件详情


                //短信订单
                Route::get('dopay','MassageController@doPay');
                Route::get('doorder','MassageController@doOrder');
                Route::get('payfor','MassageController@payfor');
                Route::get('payinfo','MassageController@payInfo');
                Route::get('doreply','MassageController@doReply');

                //在线客服
                Route::get('onlineservice','MassageController@onlineService');
                Route::get('addonlines','MassageController@addOnlines');
                Route::post('doaddonlines','MassageController@doAddOnlines');
                Route::get('onlinesinfo','MassageController@onlinesInfo');

            });
            //运营后台
//            Route::group(['prefix'=>'/business'],function(){
//                Route::get("competition","CompetitionController@index");//竞赛方案列表页
//                Route::get('create_competition','CompetitionController@addCompetition');//添加新的竞赛方案
//                Route::post('add_competition_submit','CompetitionController@addCompetitionSubmit');//竞赛方案表单提交
//                Route::get('get_detail/{competition_id}','CompetitionController@getDetail');//获取竞赛方案的具体细节
//                Route::get('get_expire','CompetitionController@getExpireCompetition');//获取已经过期的竞赛方案
//                Route::post('add_condition_submit','CompetitionController@addConditionSubmit');//添加条件
//            });

//            Route::group(['prefix'=>'/flow'],function(){  //工作流管理
//                Route::get('index','FlowController@index');
//                Route::get('add_flow','FlowController@addFlow');//跳转到工作流添加页面
//                Route::post('add_flow_submit','FlowController@addFlowSubmit');//工作流表单提交
//                Route::get('get_detail/{flow_id}','FlowController@getFlowDetail');//获取工作流的详细信息
//                Route::get('node','FlowController@node');//跳转到节点界面
//                Route::get('node_detail/{node_id}','FlowController@getNodeDetail');//跳转到节点详情页面
//                Route::get('add_node','FlowController@addNode');//跳转到添加节点yemian
//                Route::post('add_node_submit','FlowController@addNodeSubmit');//节点表单提交
//                Route::post('add_node_status','FlowController@addNodeStatus');//节点 和条件关联5
//                Route::get('behaviour','FlowController@behaviour');//跳转到行为规范页面
//                Route::get('add_behaviour','FlowController@addBehaviour');//跳转到添加行为规范页面
//                Route::get('add_behaviour/{flow_id}','FlowController@addBehaviour');//跳转到添加工作行为规范页面
//            });
//            Route::group(['prefix'=>'/table_field'],function(){//表和字段管理
//                Route::get('index','TableFieldController@index'); //默认跳转到列表页面
//                Route::get('add','TableFieldController@addTableField');  //跳转到添加表字段页面
////                Route::get('')
//            });


//            Route::group(['prefix'=>'/status'],function(){  //状态管理
//                Route::get('index','StatusController@index'); // 查看所有的状态
//                Route::get('group','StatusController@getGroup');//查看所有的分组
//                Route::get('add_group','StatusController@addGroup');//跳转到添加分组页面
//                Route::post('add_group_submit','StatusController@addGroupSubmit');//添加分组表单提交
//                Route::get('add','StatusController@addStatus'); //添加状态
//                Route::post('add_status_submit','StatusController@addStatusSubmit');//添加状态表单提交
//                Route::post('get_status_ajax','StatusController@getStatusByGroupAjax');//通过ajax获取所有的状态
//                Route::get('status_detail/{id}','StatusController@getStatusDetail');//跳转到状态的详情页面
//                Route::get('add_status_relation','StatusController@addStatusRelation');//跳转到添加状态关系页面
//                Route::post('add_status_relation_submit','StatusController@addStatusRelationSubmit');//跳转到关系表单提交页面
//                Route::post('get_children_status_ajax','StatusController@getChildrenStatusAjax');//通过ajax获取所有的子级状态
//                Route::get('group_detail/{group_id}','StatusController@getGroupDetail'); //获取状态分组详情
//            });
//            Route::group(['prefix'=>'/warranty'],function(){
//                Route::get('add_warranty/{type}','WarrantyController@addWarranty');//添加保单
//                Route::post('add_warranty_submit','WarrantyController@addWarrantySubmit');//添加保单表单提交
//                Route::get('get_warranty/{type}','WarrantyController@getWarranty'); //获取保单
//                Route::get('get_warranty_detail/{warranty_id}','WarrantyController@getWarrantyDetail');//获取保单的详细信息
//                Route::get('distribution/{warranty_id}','WarrantyController@distribution');//跳转到保单分配页面
//            });
//            Route::group(['prefix'=>'/order'],function(){
//                Route::get('get_order/{type}','OrderController@getOrder'); //获取订单
//                Route::get('get_order_detail/{order_id}','OrderController@getOrderDetail');//获取订单的详细信息
//                Route::get('add_order/{type}','OrderController@addOrder');//添加订单
//                Route::post('add_order_submit','OrderController@addOrderSubmit');//添加订单表单提交
//            });

            // 任务管理
            Route::group(['prefix'=>'/task'],function(){
                Route::get('/','TaskController@index')->name('backend.task.index'); // 任务列表
                Route::post('/','TaskController@store')->name('backend.task.store'); // 设置任务
                Route::post('/store_month','TaskController@storeMonth')->name('backend.task.store_month'); // 给某个月设置任务
            });


            // 订单管理
            Route::group(['prefix'=>'/order'],function(){
                Route::get('/','OrderManagementController@index'); //个人订单
                Route::get('personal_details','OrderManagementController@personal_details'); //个人订单详情
                Route::get('enterprise','OrderManagementController@enterprise'); //企业订单
                Route::get('order_company_details','OrderManagementController@order_company_details'); //企业订单
            });

            // 保单管理
            Route::group(['prefix'=>'/policy'],function(){
                Route::get('/','PolicyController@index'); //个人保单
                Route::get('policy_details','PolicyController@policy_details'); //个人保单详情
                Route::get('policy_company','PolicyController@policy_company'); //企业保单
                Route::get('policy_company_details','PolicyController@policy_company_details'); //企业保单详情
                Route::post('export_policy_person','PolicyController@exportPolicyPerson'); //个人保单导出
                Route::post('export_policy_company','PolicyController@exportPolicyCompany'); //企业保单导出
                Route::get('policy_offline','PolicyController@policyOffline'); //线下保单
                Route::get('policy_offline_details','PolicyController@policyOfflineDetails'); //线下保单详情页
                Route::post('update_policy_offline','PolicyController@updatePolicyOffline'); //更新线下保单数据
                Route::post('import_offline','PolicyController@importOffline'); //上传保单文件
                Route::get('check_import_status','PolicyController@checkImportStatus'); //线下保单
                Route::get('update_offline','PolicyController@updateOffline'); //更新上传的文件数据
            });

            // 理赔管理
            Route::group(['prefix'=>'/claim'],function(){
                Route::get('/','ClaimManagementController@index'); //个人保单
                Route::get('claimDetails','ClaimManagementController@claimDetails'); //个人保单详情
            });

            // 保全管理
            Route::group(['prefix'=>'/preserve'],function(){
                Route::get('/','PreserveManagementController@index'); //个人保单
                Route::get('preserveDetails','PreserveManagementController@preserveDetails'); //个人保单详情
            });

            // 财务中心
            Route::group(['prefix'=>'/finance'],function(){
                Route::get('/','FinanceController@index'); //财务中心首页
                Route::get('details','FinanceController@details'); //个人保单详情
            });

            // 个性化设置
            Route::group(['prefix'=>'/setting'],function(){
                Route::get('/','SettingController@index'); //个性化设置首页
                Route::post('/save','SettingController@save'); //个性化设置首页
                Route::post('/uploadImage','SettingController@uploadImage'); //上传图片
            });

            // 工单管理
            Route::group(['prefix'=>'/work_order'],function(){
                Route::any('/{id}','WorkOrderController@index'); //工单管理
                Route::get('details/{id}','WorkOrderController@details'); //工单管理
                Route::any('{id}/add_work','WorkOrderController@newWork'); //创建工单
                Route::any('details/{id}/{status}/add_reply','WorkOrderController@addReply'); //回复工单
                Route::any('details/{id}/{status}/add_close','WorkOrderController@addClose'); //回复工单
            });

//            业管销售统计
            Route::group(['prefix'=>'/sales'],function(){
                Route::any('show','SalesController@index');
                Route::any('agent','SalesController@agent');
                Route::any('ditch','SalesController@ditch');
                Route::get('detail/{id}','SalesController@detail');//销售详情
                Route::get('details/{id}','SalesController@details');//销售详情
                Route::get('policy','SalesController@policy');//保单查看
            });
            // 佣金统计
            Route::group(['prefix'=>'/commision'],function(){
                Route::any('index/{id}','CommissionController@index');
            });

            // 客户管理
            Route::group(['prefix'=>'/customer'],function(){
                Route::group(['prefix' => 'individual'], function () {
                    Route::get('/','Customer\\IndividualUserController@index')->name('backend.customer.individual.index'); // 个人客户列表
                    Route::get('/detail/{id}','Customer\\IndividualUserController@detail')->name('backend.customer.individual.detail'); // 个人客户详情
                    Route::get('/warranty/{id}', 'Customer\\IndividualUserController@warranty')->name('backend.customer.individual.warranty'); // 保单详情
                    Route::get('/insurance/{id}', 'Customer\\IndividualUserController@insurance')->name('backend.customer.individual.insurance'); // 保险记录
                    Route::post('/reset_password', 'Customer\\IndividualUserController@resetPassword')->name('backend.customer.individual.reset_password'); // 重置密码
                    Route::get('/verification/{id}', 'Customer\\IndividualUserController@verification')->name('backend.customer.individual.verification'); // 验证
                    Route::post('/verification', 'Customer\\IndividualUserController@verificationPost')->name('backend.customer.individual.verification.store');
                    Route::get('/operation/{id}', 'Customer\\IndividualUserController@operation')->name('backend.customer.individual.operation'); // 操作记录
                });
                Route::group(['prefix' => 'company'], function () {
                    Route::get('/', 'Customer\\CompanyUserController@index')->name('backend.customer.company.index');
                    Route::get('/detail/{id}', 'Customer\\CompanyUserController@detail')->name('backend.customer.company.detail');
                    Route::get('/warranty/{id}', 'Customer\\CompanyUserController@warranty')->name('backend.customer.company.warranty'); // 保单详情
                    Route::get('/insurance/{id}', 'Customer\\CompanyUserController@insurance')->name('backend.customer.company.insurance');

                    Route::post('/reset_password', 'Customer\\CompanyUserController@resetPassword')->name('backend.customer.company.reset_password'); // 重置密码
                    Route::get('/verification/{id}', 'Customer\\CompanyUserController@verification')->name('backend.customer.company.verification'); // 验证
                    Route::post('/verification', 'Customer\\CompanyUserController@verificationPost')->name('backend.customer.company.verification.store');
                    Route::get('/operation/{id}', 'Customer\\CompanyUserController@operation')->name('backend.customer.company.operation'); // 操作记录
                });
                Route::get('/unverified', 'Customer\\UserController@unverified')->name('backend.customer.unverified');
                Route::get('/undistributed', 'Customer\\UserController@undistributed')->name('backend.customer.undistributed');
                Route::get('/allocate_agent/{id}', 'Customer\\UserController@allocateAgent')->name('backend.customer.allocate_agent'); // 分配代理人
                Route::post('/allocate_agent', 'Customer\\UserController@allocateAgentPost')->name('backend.customer.allocate_agent.store'); // 分配代理人
                Route::any('user_list','ConsumerController@index');
                Route::get('firm','ConsumerController@firm');
                Route::get('short_message','ConsumerController@short_message');
                Route::get('custom','ConsumerController@custom'); //客户管理
                Route::get('customer_details','ConsumerController@customer_details'); //客户管理详情页
                Route::get('client_agent','ConsumerController@client_agent'); //分配代理人
                Route::get('client_policy_details','ConsumerController@client_policy_details'); //分配代理人
                Route::get('insurance_record','ConsumerController@insurance_record'); //保险记录
                Route::any('buried_point','ConsumerController@buried_point'); //埋点

            });


            // 先留着 以后删除
            Route::group(['prefix'=>'/user_management'],function(){
                Route::any('user_list','ConsumerController@index');
                Route::get('firm','ConsumerController@firm');
                Route::get('short_message','ConsumerController@short_message');
                Route::get('custom','ConsumerController@custom'); //客户管理
                Route::get('customer_details','ConsumerController@customer_details'); //客户管理详情页
                Route::get('client_agent','ConsumerController@client_agent'); //分配代理人
                Route::get('client_policy_details','ConsumerController@client_policy_details'); //分配代理人
                Route::get('insurance_record','ConsumerController@insurance_record'); //保险记录
                Route::any('buried_point','ConsumerController@buried_point'); //埋点

            });
            Route::group(['prefix'=>'/demand'],function(){//需求管理
                Route::get('index/{type}','DemandController@index');//需求管理主页面
                Route::get('detail/{demand_id}','DemandController@getDemandDetail');//跳转到需求的详细页面
                Route::get('offer/{demand_id}','DemandController@offer');//报价提交
                Route::any('addProduct/{product_name}','DemandController@addProduct');//报价提交
                Route::post('offer_submit','DemandController@offerSubmit');//提交产品组合
                Route::get('check_offer/{demand_id}','DemandController@checkOffer');//查看产品报价组合
                Route::get('deal/{type}','DemandController@deal');//跳转到已经处理的需求页面
            });
            Route::group(['prefix'=>'/statistics'],function(){//中介统计
                Route::get('premium','StatisticsController@getPremium');//保费统计
                Route::get('brokerage_statistics','StatisticsController@getBrokerageStatistics');//佣金统计
                Route::get('award_statistics','StatisticsController@getAwardStatistics');//代理人提奖记录统计
                Route::get('company_brokerage','StatisticsController@getCompanyBrokerage');//公司佣金统计
            });
            //获取分类
            Route::group(['prefix'=>'/classify'],function(){
                Route::post('get_classify','StatusClassifyController@getClassify');
            });

            Route::group(['prefix'=>'/ajax'],function(){
                Route::post('get_tables','AjaxController@getTableAjax');
                Route::post('get_tables_describe','AjaxController@getTableDescribe');
                Route::post('uploadImage','AjaxController@uploadImage');
            });
        });

        Route::group(['prefix'=>'/special'],function(){
            //工单管理路由
            Route::get('addspecial','ServerController@addSpecial');//发起工单请求
            Route::get('doaddspecial','ServerController@doAddSpecial');//处理发起

            Route::get('special','ServerController@special');//已处理
            Route::get('nospecial','ServerController@nospecial');//未处理工单
            Route::get('dospecial','ServerController@dospecial');//处理工单
            Route::get('delspecial','ServerController@delSpecial');//删除工单
            Route::get('recspecial','ServerController@recSpecial');//工单回收站
            Route::get('specialinfo','ServerController@specialInfo');

        });

        Route::group(['prefix'=>'/label'],function(){
            Route::get('user_label','LabelController@userLabel');//用户标签
            Route::get('agent_label','LabelController@agentLabel');//代理人标签
            Route::get('product_label','LabelController@productLabel');//产品标签
            Route::any('do_add_label_group','LabelController@doAddLabelGroup');//添加标签组
            Route::any('do_del_label_group','LabelController@doDellabelGroup');//删除标签组
            Route::any('do_add_label','LabelController@doAddLabel');//添加标签
            Route::any('do_del_label','LabelController@doDellabel');//删除标签
            Route::any('do_label_relevance','LabelController@doLabelRelevance');//标签和对象关联
            Route::any('del_label_relevance','LabelController@delLabelRelevance');//删除标签和对象关联

        });
        Route::group(['prefix'=>'/product'],function(){
             //产品管理
            Route::any('getproducts','ProductController@getProducts');//获取天眼后台产品池数据
            Route::any('product_stay_on','ProductController@productStayOn');//产品池/代售产品列表
            Route::any('product_details_ing/{id}','ProductController@productDetails');//产品池/代售产品详情
            Route::any('add_product_lists','ProductController@addProductLists');//把产品池的产品加入我的列表
            Route::any('add_product_up','ProductController@addProductUp');//把待售产品上架
            Route::any('product_details_edit/{id}','ProductController@productDetailsEdit');//代售产品个性化编辑
            Route::any('do_product_details_edit','ProductController@doProductDetailsEdit');//代售产品个性化编辑处理（封面和个性化编辑）
            Route::any('product_list','ProductController@productList');//我的产品列表
            Route::any('add_product_down','ProductController@addProductDown');//我的产品列表产品下架
            Route::any('product_details_on/{id}','ProductController@productDetailsOn');//我的产品详情
            Route::any('product_sold_out','ProductController@productSoldOut');//下架产品列表
            Route::any('product_sold_out_details/{id}','ProductController@productSoldOutDetails');//下架产品详情
            Route::any('product_rank_list','ProductController@productRankList');//产品排行列表
            Route::any('product_down_reason','ProductController@productDownReason');//产品下架原因处理
            Route::any('product_sale_statistics/{id}','ProductController@productSaleStatistics');//产品销售统计
            Route::any('product_comment/{id}','ProductController@productComment');//产品评论





            //2017-10-23  之前的路由  // 先留着 以后删除
            Route::get('product_details','ProductController@product_details');   //    下代售产品详情
            Route::get('product_details_on','ProductController@product_details_on');
            Route::get('getproducts2','ProductController@getProducts2');//总列表
            Route::post('productsave','ProductController@productSave');//总列表
            Route::get('productlists','ProductController@productLists');//总列表

            Route::get('productsinfo','ProductController@productsInfo');//总产品详情
            Route::get('productinfo','ProductController@productInfo');//我的产品详情
            Route::any('productsinsert','ProductController@productsInsert');//添加
            Route::any('productpersonal','ProductController@productpersonal');//个性化
            Route::get('productup','ProductController@productUp');//上架
            Route::get('productdown','ProductController@productDown');//下架
            Route::get('productchange','ProductController@productChange');//修改
            Route::get('productdel','ProductController@productDel');//删除
            Route::get('productrec','ProductController@productRec');//回收站
            Route::get('productback','ProductController@productBack');//回收还原
            //标签
            Route::any('productlabels','ProductController@productLabels');//标签
            Route::any('addlabel','ProductController@addLabel');//添加标签
            Route::any('addlabelgroup','ProductController@addLabelGroup');//添加标签组
            Route::any('doaddlabel','ProductController@doAddLabel');//添加
            Route::get('updatelabel','ProductController@updateLabel');//修改标签
            Route::any('doupdatelabel','ProductController@doUpdateLabel');//修改
            Route::any('addproductlabel','ProductController@addProductLabel');//贴标签
            Route::any('doaddproductlabel','ProductController@doAddProductLabel');//处理贴标签
            Route::any('getlabelinfo','ProductController@getLabelInfo');//标签详情
            Route::any('getproductlables','ProductController@getProductLables');
            Route::post('showproductlables','ProductController@showProductLables');//查看标签详情
            Route::any('updateproductlabels','ProductController@updateProductLables');//修改产品标签
        });

        //渠道（韵达，斗腕等）
        Route::group(['prefix'=>'/channels'],function(){
            Route::get('douwan','ChannelsDouwanController@Index');//斗腕投保信息展示
            Route::get('douwan/do_insure/{code}','ChannelsDouwanController@doInsure');//斗腕投保信息展示
            Route::get('yunda/brokerage','ChannelsYundaController@brokerage');//韵达佣金信息展示

        });


    });

    Route::get('login','LoginController@index');
    Route::post('do_login','LoginController@login');
    Route::get('logout','LoginController@logout');
    Route::get('modify','LoginController@modify');


    Route::group(['prefix'=>''],function(){
        //接口
        Route::any('sendsms','InterfacesController@sendSms');//短信接口调用
        Route::any('passservice','InterfacesController@passservice');//短信接口调用
        Route::any('companysendemail','InterfacesController@companySendEmail');//企业注册邮箱验证码
        Route::any('sendemail','InterfacesController@sendEmails');//邮箱接口调用
        Route::any('emailfilesend','InterfacesController@emailFilesSend');//发送邮件



//    //信息管理
//    Route::get('email','MassageController@email');//邮件
//    Route::get('mail','MassageController@mail');//站内信
//    Route::get('sms','MassageController@sms');//短信
//    Route::get('smsinfo','MassageController@smsInfo');
//    Route::get('smsinfolist','MassageController@smsInfoList');
//    Route::get('smslistinfo','MassageController@smsListInfo');

//    Route::get('savetoken','MassageController@saveToken');//保存token
//    Route::get('test','MassageController@test');//改变状态
//    Route::get('changestatus','MassageController@changeStatus');//test
//    Route::any('hassendemail','MassageController@hasSendEmail');//已发送邮件
//    Route::any('emailmodels','MassageController@emailModels');//邮件模板
//    Route::any('addemailmodels','MassageController@addEmailModels');//添加邮件模板
//    Route::any('doaddmodels','MassageController@doAddEmailModels');//处理添加模板
//    Route::any('getemailmodels','MassageController@getEmailModels');//获取模板
//    Route::any('emailmodelsinfo','MassageController@emailModelsInfo');//查看模板详情
//    Route::any('hasemailinfo','MassageController@hasEmailInfo');//查看已发邮件详情
//
//
//    //短信订单
//    Route::get('dopay','MassageController@doPay');
//    Route::get('doorder','MassageController@doOrder');
//    Route::get('payfor','MassageController@payfor');
//    Route::get('payinfo','MassageController@payInfo');
//    Route::get('doreply','MassageController@doReply');


//
//            //产品管理
//            Route::get('getproducts','ProductController@getProducts');//总列表
//            Route::get('getproducts2','ProductController@getProducts2');//总列表
//            Route::post('productsave','ProductController@productSave');//总列表
//            Route::get('productlists','ProductController@productLists');//总列表
//            Route::get('productlist','ProductController@productList');//我的列表
//            Route::get('productsinfo','ProductController@productsInfo');//总产品详情
//            Route::get('productinfo','ProductController@productInfo');//我的产品详情
//            Route::get('addproductlists','ProductController@addProductLists');//添加
//            Route::any('productsinsert','ProductController@productsInsert');//添加
//            Route::any('productpersonal','ProductController@productpersonal');//个性化
//            Route::get('productup','ProductController@productUp');//上架
//            Route::get('productdown','ProductController@productDown');//下架
//            Route::get('productchange','ProductController@productChange');//修改
//            Route::get('productdel','ProductController@productDel');//删除
//            Route::get('productrec','ProductController@productRec');//回收站
//            Route::get('productback','ProductController@productBack');//回收还原
//            //标签
//            Route::get('productlabels','ProductController@productLabels');//标签
//            Route::get('addlabel','ProductController@addLabel');//添加标签
//            Route::get('addlabelgroup','ProductController@addLabelGroup');//添加标签组
//            Route::get('doaddlabel','ProductController@doAddLabel');//添加
//            Route::get('updatelabel','ProductController@updateLabel');//修改标签
//            Route::get('doupdatelabel','ProductController@doUpdateLabel');//修改
//            Route::get('addproductlabel','ProductController@addProductLabel');//贴标签
//            Route::get('doaddproductlabel','ProductController@doAddProductLabel');//贴标签
//            Route::get('getlabelinfo','ProductController@getLabelInfo');
//            Route::get('getproductlables','ProductController@getProductLables');
//            Route::post('showproductlables','ProductController@showProductLables');

    });
    //回调处理工单
    Route::any('hasdospecial', 'ServerController@hasDoSpecial');//返回处理工单状态
    Route::any('updatecliamsubmit', 'ClaimController@updateClaimSubmit');//返回处理理赔状态
    Route::any('updatepreservation', 'MaintenanceController@updatePreservationSubmit');//返回处理保全状态

});

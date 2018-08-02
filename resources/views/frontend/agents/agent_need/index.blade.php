@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/requirement.css" />
    <div>
        <ul class="tab">
            <li class="active"><a href="/agent_sale/agent_need">发起需求工单</a></li>
            <li><a href="/agent_sale/agent_need_lists">我的工单</a></li>
        </ul>
    </div>
    <div class="content content-form">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <form action="" method="">
        <table>
            <tr>
                <td>收件人</td>
                <td>
                    <select id="receiver" name="recipient_id">
                        <option value="" selected disabled>请选择</option>
                        <option value="0">业管张某某</option>
                        <option value="-1">天眼后台</option>
                    </select>
                </td>
                <td>所属模块</td>
                <td>
                    <select id='module' name="module">
                        <option value="0" selected disabled>请选择</option>
                        <option value="1">客户</option>
                        <option value="2">产品</option>
                        <option value="3">计划书</option>
                        <option value="4">销售业绩</option>
                        <option value="5">销售任务</option>
                        <option value="6">活动</option>
                        <option value="7">消息</option>
                        <option value="8">评价</option>
                        <option value="9">账户设置</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>工单标题</td>
                <td colspan="3"><input id="title" name="title" type="text" placeholder="请填写"/></td>
            </tr>
            <tr height="360">
                <td>工单正文</td>
                <td colspan="3"><textarea id="content" name="content" placeholder="请填写详细说明"></textarea></td>
            </tr>
        </table>
        </form>

        <button id="create" class="z-btn z-btn-positive" disabled style="display: block;margin: 120px auto; width: 180px;">发送</button>
    </div>
    <div class="content content-success" style="display: none;">
        <div class="success">
            <div class="tips-wrapper" style="margin: 100px 100px;">
                <i class="iconfont icon-shenqingchenggong"></i>
                <p class="text">发送成功</p>
            </div>
            <button id="again" class="z-btn z-btn-positive" style="width: 176px;margin: 0 auto;display: block;">继续发起工单</button>
        </div>
    </div>

    <script>
        var Ele = {
            receiver : $('#receiver'),
            module : $('#module'),
            btn_again: $('#again'),
            btn_create: $('#create'),
            title : $('#title'),
            content: $('#content'),
            content_form : $('.content-form'),
            content_success : $('.content-success'),
        }

        // 监听按钮是否可用
        $("input,textarea").bind('input porpertychange',function(){
            isDisabled();
        });
        $('#receiver,#module').change(function(){
            isDisabled();
        });

        function checkValue(){
            if(!Ele.receiver.val() || !Ele.module.val() || !Ele.title.val() || !Ele.content.val()){
                return false;
            }else{
                return true;
            }
        }
        function isDisabled(){
            if(!checkValue()){
                Ele.btn_create.prop('disabled',true);
            }else{
                Ele.btn_create.prop('disabled',false);
            }
        }

        Ele.btn_create.click(function(){
            //  提交数据成功后
//            var data = $('form').serialize();
            var recipient_id = $("#receiver").val();
            var module = $("#module").val();
            var title = $("input[name='title']").val();
            var content = $("#content").val();
            var _token = $("input[name='_token']").val();
            $.ajax({
                url:'/agent_sale/agent_need_submit',
                type:'post',
                data:{_token:_token,recipient_id:recipient_id,module:module,title:title,content:content},
                success:function(res){
                    if(res['status'] == 200){
                        Ele.content_form.hide();
                        Ele.content_success.show();
                    }else{
                        alert(res['msg']);
                    }
                }
            });

        });
        Ele.btn_again.click(function(){
            location.reload();
        })
    </script>
    @stop
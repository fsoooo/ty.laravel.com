@extends('backend.layout.base')
<link href="/r_backend/win/window/window.css" rel="stylesheet" />
@section('content')
    <div id="content-wrapper" class="email-inbox-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div id="email-box" class="clearfix" style="min-height: 1200px;">
                    <div class="row">
                        <div class="col-lg-12">
                            <ol class="breadcrumb">
                                <li><a href="{{ url('/backend') }}">主页</a></li>
                                <li ><span>产品管理</span></li>
                                <li><span><a href="/backend/product/productlists">产品池</a></span></li>
                                <li class="active"><span><a href="/backend/product/productlists">产品池列表</a></span></li>
                            </ol>
                            <header id="email-header" class="clearfix">
                                <div id="email-header-tools" style="margin:0 auto; margin-left:10px;">
                                    <div class="btn-group">
                                        <a id="btn-select"><button class="btn btn-primary" type="button" title="全选/取消"  >
                                                <i class="iconfont icon-quanxuan"></i>
                                            </button></a>
                                        <input hidden type="checkbox" name="allChecked" id="allChecked" onclick="DoCheck()"/>
                                    </div>
                                    <div class="btn-group">
                                        <a onclick="refresh()"><button class="btn btn-primary" type="button" title="更新"  >
                                                <i class="iconfont icon-shuaxin"></i>
                                            </button></a>
                                        <a onclick="doSelected()"><button class="btn btn-primary" type="button" title="同步" data-toggle="tooltip" data-placement="bottom">
                                                <i class="fa fa-plus-circle fa-lg"></i>
                                            </button></a>
                                    </div>
                                </div>
                            </header>
                        </div>
                    </div>
                    <div class="main-box-body clearfix">
                        <div class="table-responsive">
                            <table class="table user-list table-hover">
                                <tbody>
                                <tr>
                                    <th></th>
                                    <th class="text-center"><span>保险产品简称</span></th>
                                    <th class="text-center">保险产品全称</th>
                                    <th class="text-center"><span>保险产品分类</span></th>
                                    <th class="text-center"><span>保险公司</span></th>
                                    <th>同步状态</th>
                                </tr>
                                {{--</thead>--}}
                                {{--<tr>--}}
                                    {{--<td class="chbox">--}}
                                        {{--<i class="iconfont icon-danxuan"></i>--}}
                                        {{--<input hidden type="checkbox" name="choose" value="1" />--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--<a href="">22</a>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--44--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--66--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--标签已选择--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--标签已选择--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td class="chbox">--}}
                                        {{--<i class="iconfont icon-danxuan"></i>--}}
                                        {{--<input hidden type="checkbox" name="choose" value="1" />--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--<a href="">22</a>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--44--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--66--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--标签已选择--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--标签已选择--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td class="chbox">--}}
                                        {{--<i class="iconfont icon-danxuan"></i>--}}
                                        {{--<input hidden type="checkbox" name="choose" value="1" />--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--<a href="">22</a>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--44--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--66--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--标签已选择--}}
                                    {{--</td>--}}
                                    {{--<td class="text-center">--}}
                                        {{--标签已选择--}}
                                    {{--</td>--}}
                                {{--</tr>--}}

                                @foreach($res as $k => $v)
                                <tr>
                                <td class="chbox">
                                <input type="checkbox" name="choose" value="{{$v['id']}}" />
                                </td>
                                <td class="text-center">
                                <a href="productsinfo?id={{$v['id']}}">{{$v['id']}}
                                {{$v['display_name']}}
                                </a>
                                </td>
                                <td class="text-center">
                                {{$v['name']}}
                                </td>
                                <td class="text-center">
                                {{$v['category']['name']}}
                                </td>
                                <td class="text-center">
                                {{$v['company']['display_name']}}
                                </td>
                                <td style="width: 15%;">
                                @if(!empty($product_id))
                                @if(in_array($v['id'],$product_id))
                                <span class="label label-success">已同步</span>
                                @else
                                <span class="label label-danger">未同步</span>
                                @endif
                                @else
                                <span class="label label-danger">未同步</span>
                                @endif
                                </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{--@if($currentPage== '1')--}}
                    {{--@if($currentPage==$pages)--}}
                    {{--<a onclick='getData("{{$currentPage}}")'><button>当前页:{{$currentPage }}</button></a>--}}
                    {{--<a onclick='getData("{{$currentPage+1}}")'><button>下一页</button></a>--}}
                    {{--<a onclick='getData("{{$pages}}")'><button>尾页</button></a>--}}
                    {{--<a><button>总页数{{$pages }}</button></a>--}}
                    {{--@elseif($currentPage->$pages)--}}
                    {{--暂无数据--}}
                    {{--<a onclick='getData("{{$currentPage}}")'><button>当前页:{{$currentPage }}</button></a>--}}
                    {{--<a onclick='getData("{{$currentPage+1}}")'><button>下一页</button></a>--}}
{{--                    <a onclick='getData("{{$pages}}")'><button>尾页</button></a>--}}
                    {{--<a><button>总页数{{$pages }}</button></a>--}}
                    {{--@else--}}
                    {{--<a onclick='getData("{{$currentPage}}")'><button>当前页:{{$currentPage }}</button></a>--}}
                    {{--<a onclick='getData("{{$currentPage+1}}")'><button>下一页</button></a>--}}
                    {{--<a onclick='getData("{{$pages}}")'><button>尾页</button></a>--}}
                    {{--<a><button>总页数{{$pages }}</button></a>--}}
                    {{--@endif--}}
                    {{--@elseif($currentPage==$pages)--}}
                    {{--<a onclick='getData("1")'><button>首页</button></a>--}}
                    {{--<a onclick='getData("{{$currentPage-1}}")'><button>上一页</button></a>--}}
                    {{--<a onclick='getData("{{$currentPage}}")'><button>当前页:{{$currentPage }}</button></a>--}}
                    {{--<a><button>总页数{{$pages }}</button></a>--}}
                    {{--@else--}}
                    {{--<a onclick='getData("1")'><button>首页</button></a>--}}
                    {{--<a onclick='getData("{{$currentPage-1}}")'><button>上一页</button></a>--}}
                    {{--<a onclick='getData("{{$currentPage}}")'><button>当前页:{{$currentPage }}</button></a>--}}
                    {{--<a onclick='getData("{{$currentPage+1}}")'><button>下一页</button></a>--}}
                    {{--<a onclick='getData("{{$pages}}")'><button>尾页</button></a>--}}
                    {{--<a><button>总页数{{$pages }}</button></a>--}}
                    {{--@endif--}}
                </div>
            </div>
        </div>
    </div>
    <script src="/r_backend/win/window/window.js"></script>
    <script type="text/javascript">
        function DoCheck()
        {
            var ch=document.getElementsByName("choose");
            if(document.getElementsByName("allChecked")[0].checked==true)
            {
                for(var i=0;i<ch.length;i++)
                {
                    ch[i].checked=true;
                }
            }else{
                for(var i=0;i<ch.length;i++)
                {
                    ch[i].checked=false;
                }
            }
        }
        function refresh(){
            window.location.href=location;
        }

        function refresh(){
            window.location.href=location;
        }
        function doSelected(){
            var choose = document.getElementsByName("choose");
            var num = choose.length;
            var id = "";
            for(var index =0 ; index<num ; index++){
                if(choose[index].checked){
                    id += choose[index].value + ",";
                }
            }
            if(id!=""){
                if(window.confirm("确定添加所选产品？")){
                    win.confirm('系统提示', '再次添加已同步商品会清除已同步商品所有设置！！', function(r){
//                                                                                win.alertEx('结果：' + (r ? "是" : "不是"))
                        var msg = "取消操作！！";
                        r ? $.ajax( {
                            type : "get",
                            url : 'addproductlists?id=' + id,
                            dataType : 'json',
                            success:function(msg){
                                if(msg.status = true){
                                    win.alertEx(msg.message);
                                    location.reload();
                                }else{
                                    win.alertEx(msg.message);
                                }
                            }
                        }):win.alertEx(msg)
                    });
                }
            }else{
                win.alertEx("请选择要添加的商品");
            }
        }
    </script>
@stop

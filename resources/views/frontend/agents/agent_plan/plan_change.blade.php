@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/prospectus.css" />

    <ul class="tab">
        <li><a href="/agent_sale/add_plan">制作计划书</a></li>
        <li ><a href="/agent_sale/plan_lists">已制作计划书</a></li>
        <li class="active"><a href="/agent_sale/plan_change">已转化计划书</a></li>
    </ul>


    <div class="content">
        <table>
            <tr>
                <th>计划书编号</th>
                <th>发出时间</th>
                <th>姓名</th>
                <th>性别</th>
                <th>年龄</th>
                <th>计划书名称</th>
                <th>保障期间</th>
                <th>保费（元）</th>
                <th>状态</th>
                <th>查看详情</th>
            </tr>
            @if($lists_count ==0)
                <tr><td>没有已经购买过的过计划书</td></tr>
            @else
            @foreach($lists as $k=>$v)
                    <tr>
                        <td>{{$v->lists_id}}</td>
                        @if(isset($v->send_time))
                            <td>{{date('Y-m-d',$v->send_time)}}</td>
                        @else
                            <td> -- </td>
                        @endif
                        <td>{{$v->name}}</td>
                        <td>
                            @if(substr($v->code,16,1)%2 ==1)
                                男
                                @else
                            女
                                @endif
                        </td>
                        <td>{{date('Y',time()) - substr($v->code,6,4)}}岁</td>
                        <td><a href="/agent_sale/plan_detail/{{$v->lists_id}}">{{$v->plan_name}}</a></td>
                        <td>{{explode(" ",$v->plan_created_at)[0]}}起</td>
                        <td>{{$v->premium/100}}元</td>
                        <td>
                            已购买
                        </td>
                        <td><a href="/agent_sale/plan_prospectus/{{$v->lists_id}}">更多</a></td>
                    </tr>
                @endforeach
            @endif
        </table>
        <ul class="pagination">
            {{$lists->links()}}
        </ul>
    </div>


    @stop
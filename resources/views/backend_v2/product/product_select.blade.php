{{--业管后台产品管理顶部筛选模块--}}
<?php
$product_on_active =   preg_match("/product_list/",Request::getRequestUri()) || preg_match("/product_details_on/",Request::getRequestUri())? "active" : '';
$product_ing_active =  preg_match("/product_stay_on/",Request::getRequestUri()) || preg_match("/product_details/",Request::getRequestUri())|| preg_match("/product_details_edit/",Request::getRequestUri())? "active" : '';
$product_down_active = preg_match("/product_sold_out/",Request::getRequestUri())|| preg_match("/product_sold_out_details/",Request::getRequestUri()) ? "active" : '';
?>
<div class="row">
    <div class="select-wrapper radius">
        <form role="form" class="form-inline radius" style="overflow: hidden">
            <div class="form-group col-lg-10">
                @if($product_down_active=="active")
                    <div class="select-item">
                        <label for="name">停售时间:</label>
                        <div class="input-group date form_date">
                            @if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_stop_sale')
                                <input id="date" class="form-control" name="ins_time" type="text" placeholder="{{$_GET['keyword']}}" readonly>
                            @else
                                <input id="date" class="form-control" name="ins_time" type="text" value="" placeholder="请选择" readonly>
                            @endif
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                @else
                <div class="select-item">
                    <label for="name">上架时间:</label>
                    <div class="input-group date form_date">
                        @if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_up')
                            <input id="date" class="form-control" name="ins_time" type="text" placeholder="{{$_GET['keyword']}}" readonly>
                        @else
                            <input id="date" class="form-control" name="ins_time" type="text" value="" placeholder="请选择" readonly>
                        @endif
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
                @endif
                <div class="select-item">
                    <label for="name">所属公司:</label>
                    @if(isset($categorys['company'])&&count($categorys['company'])>0)
                        {{--<select class="form-control" id="ins_company_type">--}}
                            {{--@if(count($categorys['company'])==0)--}}
                                {{--<option>公司名称</option>--}}
                            {{--@else--}}
                                {{--@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_company_type')--}}
                                    {{--<option>{{$_GET['keyword']}}</option>--}}
                                    {{--@foreach($categorys['company'] as $key=>$value)--}}
                                        {{--@if(!preg_match('/-/',$key))--}}
                                            {{--@if($value!=$_GET['keyword'])--}}
                                                {{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
                                            {{--@endif--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--@else--}}
                                    {{--@foreach($categorys['company'] as $key=>$value)--}}
                                            {{--@if(!preg_match('/-/',$key))--}}
                                            {{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
                                            {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            {{--@endif--}}
                        {{--</select>--}}
                        {{--<select class="form-control" id="ins_company_type">--}}
                            {{--@if(count($categorys['company'])==0)--}}
                                {{--<option>公司名称</option>--}}
                            {{--@else--}}
                                {{--@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_company_type')--}}
                                    {{--<option>{{$_GET['keyword']}}</option>--}}
                                    {{--@foreach($categorys['company'] as $key=>$value)--}}
                                        {{--@if(preg_match('/--/',$key))--}}
                                            {{--@if($value!=$_GET['keyword'])--}}
                                                {{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
                                            {{--@endif--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--@else--}}
                                    {{--@foreach($categorys['company'] as $key=>$value)--}}
                                        {{--@if(preg_match('/-/',$key))--}}
                                            {{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            {{--@endif--}}
                        {{--</select>--}}
                        <select class="form-control" id="ins_company">
                                <option @if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_company') value="0" @endif>
                                @if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_company'){{$_GET['keyword']}}@else全部公司@endif
                                </option>
                                @if(count($companys)==1)
                                    <option>{{$companys[0]}}</option>
                                @else
                                    @foreach($companys as $key=>$value)
                                        <option>{{$value}}</option>
                                    @endforeach
                                @endif
                        </select>
                    @else
                        <select class="form-control" id="ins_company_type">
                            <option value="0">全部分类</option>
                        </select>
                    @endif
                </div>
                <div class="select-item">
                    <label for="name">产品分类:</label>
                    @if(isset($categorys['insurance'])&&count($categorys['insurance'])>0)
                        <select class="form-control" id="ins_main_type">
                            <option @if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_main_type') value="0" @endif>
                                @if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_main_type'){{$_GET['keyword']}}@else全部分类@endif
                            </option>
                            @if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_main_type')
                                <option>{{$_GET['keyword']}}</option>
                                @foreach($categorys['insurance'] as $key=>$value)
                                    @if(!preg_match('/-/',$key))
                                        @if($value!=$_GET['keyword'])
                                            <option>{{preg_replace('/-/',' ',$value)}}</option>
                                        @endif
                                    @elseif(!preg_match('/--/',$key))
                                        @if($value!=$_GET['keyword'])
                                            <option>
                                                @if(preg_match('/-/',preg_replace('/--/',' ',$value)))
                                                    {{preg_replace('/-/',' ',$value)}}
                                                @else
                                                    {{preg_replace('/--/',' ',$value)}}
                                                @endif
                                            </option>
                                        @endif
                                    @elseif(!preg_match('/---/',$key))
                                        @if($value!=$_GET['keyword'])
                                            <option class="1">{{preg_replace('/--/',' ',$value)}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                @if(isset($categorys['insurance'])&&count($categorys['insurance'])>0&&is_array($categorys['insurance']))
                                @foreach($categorys['insurance'] as $key=>$value)
                                    @if(!preg_match('/-/',$key))
                                        <option>{{preg_replace('/-/',' ',$value)}}</option>
                                    @elseif(!preg_match('/--/',$key))
                                            <option>
                                                @if(preg_match('/-/',preg_replace('/--/',' ',$value)))
                                                    {{preg_replace('/-/',' ',$value)}}
                                                @else
                                                    {{preg_replace('/--/',' ',$value)}}
                                                @endif
                                            </option>
                                    @elseif(!preg_match('/---/',$key))
                                        <option>{{preg_replace('/--/',' ',$value)}}</option>
                                    @endif
                                @endforeach
                                @endif
                            @endif
                        </select>
                        {{--<select class="form-control" id="ins_main_type">--}}
                            {{--@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_main_type')--}}
                                {{--<option>{{$_GET['keyword']}}</option>--}}
                                {{--@foreach($categorys['insurance'] as $key=>$value)--}}
                                    {{--@if(preg_match('/--/',$value)&&!preg_match('/---/',$value))--}}
                                        {{--@if($v!=$_GET['keyword'])--}}
                                            {{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
                                        {{--@endif--}}
                                    {{--@endif--}}
                                {{--@endforeach--}}
                            {{--@else--}}
                                {{--@foreach($categorys['insurance'] as $key=>$value)--}}
                                    {{--@if(preg_match('/--/',$value)&&!preg_match('/---/',$value))--}}
                                        {{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
                                    {{--@endif--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</select>--}}
                        {{--<select class="form-control" id="ins_main_type">--}}
                            {{--@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_main_type')--}}
                                {{--<option>{{$_GET['keyword']}}</option>--}}
                                {{--@foreach($categorys['insurance'] as $key=>$value)--}}
                                    {{--@if(preg_match('/---/',$value))--}}
                                        {{--@if($value!=$_GET['keyword'])--}}
                                            {{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
                                        {{--@endif--}}
                                    {{--@endif--}}
                                {{--@endforeach--}}
                            {{--@else--}}
                                {{--@foreach($categorys['insurance'] as $key=>$value)--}}
                                    {{--@if(preg_match('/---/',$value))--}}
                                        {{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
                                    {{--@endif--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</select>--}}
                    @else
                        <select class="form-control" id="ins_main_type">
                            <option value="0">全部分类</option>
                        </select>
                    @endif
                </div>
            </div>
            @if(count($res)>0)
            <div class="col-lg-2 text-right">
                @if($product_on_active=='active')
                    <button type="button" id="all" class="btn btn-warning">选择全部</button>
                    <button type="button" id="product_down" class="btn btn-warning">下架产品</button>
                @elseif($product_ing_active=='active')
                    <button type="button" id="all" class="btn btn-warning">选择全部</button>
                    <button type="button"  class="btn btn-warning" data-toggle="modal" data-target="#addTaskSync">同步产品</button>
                    <button type="button"  class="btn btn-warning" data-toggle="modal" data-target="#addTask">上架产品</button>
                @elseif($product_down_active=='active')
                    <button type="button" id="all" class="btn btn-warning">选择全部</button>
                    <button type="button"  class="btn btn-warning" data-toggle="modal" data-target="#addTask">上架产品</button>
                @endif
            </div>
            @endif
        </form>
    </div>
</div>
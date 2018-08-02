@extends('backend_v2.layout.base')
@section('title')@parent 任务管理 @stop
@section('head-more')
    <link rel="stylesheet" type="text/css" href="{{asset('r_backend/v2/css/nifty-component.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('r_backend/v2/css/activity.css')}}"/>
@endsection
@section('top_menu')
    @include('backend_v2.task.top_menu')
@stop
@section('main')
    <div id="activity" class="main-wrapper">
        <div class="select-wrapper radius">
            <div class="row">
                <div class="col-lg-12">
                    <form role="form" class="form-inline radius">
                        <div class="form-group">
                            <label for="name">任务渠道:</label>
                            <select class="form-control" id="select-ditch" >
                                <option value="0">全部渠道</option>
                                @foreach($ditches as $ditch)
                                    <option value="{{ $ditch['id'] }}" {{ isset($selected_ditch['id']) && $ditch['id'] == $selected_ditch['id'] ? 'selected' : '' }}>{{ $ditch['name'] }}</option>
                                @endforeach
                            </select>
                            <label for="name">代理人:</label>
                            <select name="" id="select-agent" class="form-control">
                            </select>
                        </div>
                            <button id="setTask" type="button" class="btn btn-primary md-trigger fr" data-modal="modal-9">设置任务</button>
                    </form>
                </div>
            </div>

            <div class="row select-wrapper">
                <div class="col-lg-12">
                    <div class="chart-wrapper">
                        <div class="chart-header">
                            <span class="chart-title">任务统计</span>
                            <select class="form-control fr" id="select-year">
                                @foreach($years as $y)
                                    <option value="{{ $y }}" {{ $y == $year ? 'selected': '' }}>{{ $y }}年</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="main-echarts" style="width:96%;height:180px;"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="ui-table col-lg-12">
                    <div class="ui-table-header radius">
                        <span class="col-md-4">追加时间</span>
                        <span class="col-md-5">操作</span>
                        <span class="col-md-3">目标金额</span>
                    </div>
                    <div class="ui-record">
                        <ul>
                            @foreach($taskRecords as $record)
                                <li class="ui-record-tr">
                                    <div class="col-md-4">{{ $record['created_at']->format('Y年 m月 d日') }}</div>
                                    <div class="col-md-5">{{ $record['desc'] }}</div>
                                    <div class="col-md-3">¥ {{ $record['money'] }}</div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                {{ $taskRecords->appends(['ditch'=>$ditch_id,'agent' => $agent_id])->links() }}
            </div>
            <button id="task-month-button" class="md-trigger btn btn-primary" data-modal="modal-8" style="display: none;"></button>
        </div>
    </div>
    <div class="addTask md-modal md-effect-5 md-hide" id="modal-8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="md-content">
            <div class="modal-header notitle">
                <button class="md-close close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
            </div>
            <div class="modal-body">
                <form role="form" id="form-task-month" action='{{ route('backend.task.store_month') }}' class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <ul>
                    @if (!empty($selected_ditch))
                            <li>
                                <span class="name">渠道:</span>{{ $selected_ditch['name'] }}
                                <input type="hidden" type="text" name="ditch" value="{{ $selected_ditch['id'] }}">
                            </li>
                    @else
                            <li>
                                <span class="name">渠道:</span>所有渠道
                            </li>
                    @endif
                    @if (!empty($selected_agent))
                            <li>
                                <span class="name">代理人: </span>{{ $selected_agent['user']['name'] }}
                                <input type="hidden" type="text" name="agent" value="{{ $selected_agent['id'] }}">
                            </li>
                    @else
                            <li>
                                <span class="name">代理人: </span>所有代理人
                            </li>
                    @endif
                        <li>
                            <span class="name">月份: </span><span id="current-month"></span>
                            <input type="hidden" name="month" id="current-month-input">
                        </li>
                        <li>
                            <span class="name">现有任务: </span>
                            <span id="current-money"></span>元
                        </li>
                        <li>
                            <span class="name">重设额度: </span>
                            <input type="text" name="money">元
                        </li>
                    </ul>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="form-submit-month" class="btn btn-primary">确认提交</button>
            </div>
        </div>
        </div>
    </div>
    <div class="addTask md-modal md-effect-5 md-hide" id="modal-9" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="md-content">
                <div class="modal-header notitle">
                    <button class="md-close close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
                </div>
                <div class="modal-body">
                    <div class="select-header"><span class="select-item active">追加任务</span><span class="select-item">更新月任务</span></div>
                    <div class="select-content">
                        <div class="select-item">
                            <form role="form" id="form-task" action='{{ route('backend.task.store') }}' class="form-horizontal" method="post">
                                {{ csrf_field() }}
                                <ul>
                                    <li>
                                        <span class="name"> 总任务：</span>{{ $taskTotalMoney }}元
                                    </li>
                                    <li>
                                        <span class="name"> 当前任务：</span>{{ $currentTaskTotalMoney }}元
                                    </li>
                                    <li>
                                        <span class="name">渠道</span>
                                        <select name="ditches" id="ditches" class="form-control">
                                            <option value="0">所有渠道</option>
                                            @foreach($ditches as $ditch)
                                                <option value="{{ $ditch['id'] }}">{{ $ditch['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </li>
                                    <li>
                                        <span class="name">代理人</span>
                                        <select name="agents" id="agents" class="form-control">
                                            <option value="0">所有代理人</option>
                                        </select>
                                    </li>
                                    <li>
                                        <span class="name">追加任务：</span><input type="text" name="money" >元
                                    </li>
                                    <li>
                                        <span class="name">时间：</span>
                                        <select name="type" class="form-control">
                                            <option value="year">年任务</option>
                                            <option value="season">季度任务</option>
                                            <option value="month">月任务</option>
                                        </select>
                                    </li>
                                    <li id="tr-type-season" hidden>
                                        <span class="name">选择季度</span>
                                        <ul class="checkbox">
                                            <li>
                                                第一季度
                                                <label>
                                                    <i class="iconfont icon-weixuan"></i>
                                                    <input hidden type="checkbox" name="season[]" value="1" />
                                                </label>
                                            </li>
                                            <li>
                                                第二季度
                                                <label>
                                                    <i class="iconfont icon-weixuan"></i>
                                                    <input hidden type="checkbox" name="season[]" value="2" />
                                                </label>
                                            </li>
                                            <li>
                                                第三季度
                                                <label>
                                                    <i class="iconfont icon-weixuan"></i>
                                                    <input hidden type="checkbox" name="season[]" value="3" />
                                                </label>
                                            </li>
                                            <li>
                                                第四季度
                                                <label>
                                                    <i class="iconfont icon-weixuan"></i>
                                                    <input hidden type="checkbox" name="season[]" value="4" />
                                                </label>
                                            </li>
                                        </ul>
                                    </li>
                                    <li id="tr-type-month" hidden>
                                        <span class="name">选择月份</span>
                                        <ul class="checkbox">
                                            @for($i=1; $i<=12; $i++)
                                                <li>
                                                    第{{ $i }}月份
                                                    <label>
                                                        <i class="iconfont icon-weixuan"></i>
                                                        <input hidden type="checkbox" value="{{ $i }}" name="months[]" />
                                                    </label>
                                                </li>
                                            @endfor
                                        </ul>
                                    </li>
                                </ul>
                                <div class="modal-footer">
                                    <button type="button" id="form-submit" class="btn btn-primary">确认提交</button>
                                </div>
                            </form>
                        </div>
                        <div class="select-item" style="display: none;">
                            <form role="form" id="form-task-month2" action='{{ route('backend.task.store_month') }}' class="form-horizontal" method="post">
                                {{ csrf_field() }}
                                <ul>
                                    @if (!empty($selected_ditch))
                                        <li>
                                            <span class="name">渠道:</span>{{ $selected_ditch['name'] }}
                                            <input type="hidden" type="text" name="ditch" value="{{ $selected_ditch['id'] }}">
                                        </li>
                                    @else
                                        <li>
                                            <span class="name">渠道:</span>所有渠道
                                        </li>
                                    @endif
                                    @if (!empty($selected_agent))
                                        <li>
                                            <span class="name">代理人: </span>{{ $selected_agent['user']['name'] }}
                                            <input type="hidden" type="text" name="agent" value="{{ $selected_agent['id'] }}">
                                        </li>
                                    @else
                                        <li>
                                            <span class="name">代理人: </span>所有代理人
                                        </li>
                                    @endif
                                        <li>
                                            <span class="name">选择月份</span>
                                            <select class="form-control" name="month">
                                                @for($i=1; $i<=12; $i++)
                                                    <option value="{{ $i }}">
                                                        第{{ $i }}月份
                                                    </option>
                                                @endfor
                                            </select>
                                        </li>
                                    <li>
                                        <span class="name">重设额度: </span>
                                        <input type="text" name="money">元
                                    </li>
                                </ul>
                                <div class="modal-footer">
                                    <button type="button" id="form-submit-month2" class="btn btn-primary">确认提交</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="md-overlay"></div>
@endsection
@section('footer-more')
    <script charset="utf-8" src="{{ asset('r_backend/v2/js/lib/modernizr.custom.js') }}"></script>
    <script charset="utf-8" src="{{ asset('r_backend/v2/js/lib/classie.js') }}"></script>
    <script charset="utf-8" src="{{ asset('r_backend/v2/js/lib/modalEffects.js') }}"></script>
    <script>
        $(function () {
            // 复选框
            new CheckTable('.checkbox');
            new TabControl('.modal-body');
            // 渲染代理人列表
            var all_agents = '{!! $agents !!}';
            all_agents = JSON.parse(all_agents);
            $('#select-ditch').on('change', function () {
                var ditch_id = $(this).val();
                location.href = '?ditch=' + ditch_id;
            });
            @if (isset($selected_ditch['id']))
                var agents = [];
                var selected_ditch = true;
                @foreach($selected_ditch['agents'] as $key => $agent)
                    agents['{{ $key }}'] = [];
                    agents['{{ $key }}']['id'] = '{{ $agent['id'] }}';
                    agents['{{ $key }}']['name'] = '{{ $agent['user']['name'] }}';
                @endforeach
                var html = '<option value="0">全部代理人</option>';
                for (key in agents) {
                    html += '<option value="'+agents[key]['id']+'">'+agents[key]['name']+'</option>';
                }
                $('#select-agent').html(html);
                @if (isset($selected_agent['id']))
                    $('#select-agent').find('option[value="{{ $selected_agent['id'] }}"]').attr('selected', true);
                @endif
                $('#select-agent').on('change', function () {
                    location.href = '?ditch='+$('#select-ditch').val()+'&agent=' + $(this).val();
                });
            @else
                var ditch_id = $('#select-ditch').val();
                    var agents = all_agents[ditch_id];
                var html = '<option value="0">全部代理人</option>';
                for (key in agents) {
                    html += '<option value="'+agents[key]['id']+'">'+agents[key]['name']+'</option>';
                }
                $('#select-agent').html(html);
            @endif

            $('#ditches').on('change', function () {
                var ditch_id = $(this).val();
                var agents = all_agents[ditch_id];
                var html = '<option value="0">全部代理人</option>';
                for (key in agents) {
                    html += '<option value="'+agents[key]['id']+'">'+agents[key]['name']+'</option>';
                }
                $('#agents').html(html);
            });

            // 年份切换
            $('#select-year').on('change', function () {
                var url = '{{ route('backend.task.index') }}';

                @if(isset($selected_ditch['id']))
                    url = url + '?ditch=' + '{{ $selected_ditch['id'] }}' + '&year=' + $(this).val();
                @else
                    url = url + '?year=' + $(this).val();
                @endif

                @if(isset($selected_agent['id']))
                    url = url + '&agent=' + '{{ $selected_agent['id'] }}';
                @endif
                location.href = url;
            });

            // 组织echarts数据
            var should_done = [];
            @foreach($shouldDoneData as $key => $item)
                should_done['{{ $key }}'] = '{{ $item }}';
            @endforeach
            var have_done = [];
            @foreach($haveDoneData as $key => $item)
                have_done['{{ $key }}'] = '{{ $item }}';
            @endforeach
            var total_change = [];
            @foreach($haveDoneSumData as $key => $item)
                total_change['{{ $key }}'] = '{{ $item }}';
            @endforeach
            // echarts
            var myChart = echarts.init(document.getElementById('main-echarts'));
            var color = ['#da4fdc','#63dc4f','#00a2ff','#faf722','#c61e57','#1aeddc'];
            var legend = ['累计销售量', '应完成（点击重设额度）','实际完成'];
            var newData = [];
            var legend_length = legend.length;
            for(var i=0;i<legend_length;i++){
                var dataobj = {};
                dataobj.name = legend[i];
                dataobj.icon = 'pin';
                dataobj.textStyle= {};
                dataobj.textStyle.color = color[i];
                newData.push(dataobj);
            }
            // 指定图表的配置项和数据
            var option = {
                color: color,
                tooltip: {
//                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    },
                    formatter: "{a} <br/>{b}: ¥ {c}"
                },
                legend: {
                    data: newData,
                    bottom: '0px',
                    left: '20px',
                    textStyle: {
                        fontSize: 10
                    }
                },
                grid: {
                    top: '16%',
                    left: '2%',
                    right: '1%',
                    bottom: '20%',
                    containLabel: true
                },
                xAxis: [
                    {
                        type: 'category',
                        axisLabel: {
                            textStyle: {
                                color: '#83879d'
                            }
                        },
                        splitLine:{
                            show:true,
                            lineStyle:{
                                color: '#2f365a',
                                align: 'left'
                            }
                        },
                        data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12 月']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        name: '',
                        nameTextStyle: {
                            color: '#00a2ff'
                        },
                        axisLabel: {
                            formatter: '¥ {value}',
                            textStyle: {
                                color: '#00a2ff'
                            }
                        },
                        splitLine:{
                            lineStyle:{
                                color: '#2f365a'
                            }
                        }
                    }
                ],
                series: [
                    {
                        name:'累计销售量',
                        type:'line',
                        stack: '总量',
                        areaStyle: {normal: {}},
                        itemStyle: {
                            normal: {
                                barBorderRadius:[4, 4, 0, 0]
                            }
                        },
                        data: total_change
                    },
                    {
                        name:'应完成（点击重设额度）',
                        type:'bar',
                        barWidth: 20,
                        itemStyle: {
                            normal: {
                                barBorderRadius:[4, 4, 0, 0]
                            }
                        },
                        data: should_done
                    },
                    {
                        name:'实际完成',
                        type:'bar',
                        barWidth: 20,
                        itemStyle: {
                            normal: {
                                barBorderRadius:[4, 4, 0, 0]
                            }
                        },
                        data: have_done
                    }
                ]
            };
            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);

            $('#select-month').on('change', function () {
                var month = $(this).val();
                if (month == 0) {
                    return ;
                }
                var append = '';
                append += '<input type="hidden" name="month" value="'+month+'" />';
                var ditch = $('#select-ditch').find('option:selected').val();
                if (ditch != 0) {
                    append += '<input type="hidden" name="ditch" value="'+ditch+'" />';
                    var ditch_hidden = $('#form-task').find('input[name=ditch]');
                    if (ditch_hidden.length > 0) {
                        $('#form-task').find('input[name=ditch]').remove();
                    }
                }
                var agent = $('#select-agent').find('option:selected').val();
                if (agent != 0) {
                    append += '<input type="hidden" name="agent" value="'+agent+'" />';
                    var agent_hidden = $('#form-task').find('input[name=agent]');
                    if (agent_hidden.length > 0) {
                        $('#form-task').find('input[name=agent]').remove();
                    }
                }
                if (append != '') {
                    $('#form-task').append(append);
                }

                $('#form-submit-month').on('click', function () {
                    $('#form-task-month').submit();
                });
            });

            $('#form-submit-month2').on('click', function () {
                var str = $('#form-task-month2 [name=money]').val().replace(/(^\s*)|(\s*$)/g,'');
                if (str == 0 || str < 0 || !/^[0-9]+.?[0-9]*/.test(str)) {
                    return ;
                }
                $('#form-task-month2').submit();
            });

            $('#form-submit').on('click', function () {
                var str = $('#form-task [name=money]').val().replace(/(^\s*)|(\s*$)/g,'');
                if (str == 0 || str < 0 || !/^[0-9]+.?[0-9]*/.test(str)) {
                    return ;
                }
                if ($('#form-task [name=type]').val() == 1) {
                    if ($('#tr-type-1 .icon-xuanze').length <= 0) {
                        return ;
                    }
                }
                if ($('#form-task [name=type]').val() == 2) {
                    if ($('#tr-type-2 .icon-xuanze').length <= 0) {
                        return ;
                    }
                }
                $('#form-task').submit();
            });
            $('select[name=type]').on('change', function (event) {
                event.preventDefault();

                $('[id^="tr-type"]').hide();
                $('#tr-type-' + $(this).val()).show();
            });

            function eConsole(param) {
                if (param.seriesIndex == 1) {
                    $('#current-month').text(param.name);
                    $('#current-month-input').val(parseInt(param.name));
                    $('#current-money').text(param.value);
                    $('#task-month-button').trigger('click');
                    $('#form-submit-month').on('click', function () {
                        var str = $('#form-task-month [name=money]').val().replace(/(^\s*)|(\s*$)/g,'');
                        if (str == 0 || str < 0 || !/^[0-9]+.?[0-9]*/.test(str)) {
                            return ;
                        }
                        $('#form-task-month').submit();
                    });
                }
            }
            myChart.on('click', eConsole);
        });
    </script>
@endsection
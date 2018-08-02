@extends('backend.layout.base')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/nifty-component.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('r_backend/v2/css/iconfont.css')}}"/>
@endsection
@section('content')
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <div class="main-box-body clearfix">
                        <div class="clearfix">
                            <div class="col-md-2">
                                <select name="" id="select-ditch" class="form-control">
                                    <option value="0">所有渠道</option>
                                    @foreach($ditches as $ditch)
                                        <option value="{{ $ditch['id'] }}" {{ isset($selected_ditch['id']) && $ditch['id'] == $selected_ditch['id'] ? 'selected' : '' }}>{{ $ditch['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="" id="select-agent" class="form-control">
                                </select>
                            </div>
                            <div class="col-md-2">
                                销售任务：{{ format_money($result4) }}
                            </div>
                            <button id="task-month-button" class="md-trigger btn btn-primary" data-modal="modal-8" style="display: none;"></button>
                        </div>
                        <div id="main-echarts"  style="margin-top: 1%;width: 100%;height:700px;"></div>
                        <table class="table table-responsive table-bordered">
                            <h2>
                                任务记录 <button id="task-time-button" class="md-trigger btn btn-success" data-modal="modal-9">设置任务</button>
                            </h2>
                            <tr>
                                <th>追加时间</th>
                                <th>操作</th>
                                <th>目标金额</th>
                            </tr>
                            @foreach($result3 as $item)
                                <tr>
                                    <td>{{ $item['time'] }}</td>
                                    <td>追加@if ($item['type'] == 0)年@elseif($item['type'] == 1)季@elseif($item['type'] == 2)月@endif任务</td>
                                    <td>¥ {{ $item['money']/100 }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $result3->appends($_GET)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="md-overlay"></div>

    <div class="md-modal md-effect-8 md-hide" id="modal-8">
        <div class="md-content">
            <div class="modal-header">
                <button class="md-close close">×</button>
                <h4 class="modal-title">当前月追加任务</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form-task-month" action='{{ route('backend.task.store_month') }}' class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    @if (!empty($selected_ditch))
                    <div class="form-group">
                        <label class="col-md-4 text-right control-label">渠道</label>
                        <div class="col-md-4">
                            <span class="form-control">{{ $selected_ditch['name'] }}</span>
                        </div>
                    </div>
                        @else
                        <div class="form-group">
                            <label class="col-md-4 text-right control-label">渠道</label>
                            <div class="col-md-4">
                                <span class="form-control">所有渠道</span>
                            </div>
                        </div>
                    @endif
                    @if (!empty($selected_agent))
                        <div class="form-group">
                            <label class="col-md-4 text-right control-label">代理人</label>
                            <div class="col-md-4">
                                <span class="form-control">{{ $selected_agent['user']['name'] }}</span>
                            </div>
                        </div>
                        @else
                        <div class="form-group">
                            <label class="col-md-4 text-right control-label">代理人</label>
                            <div class="col-md-4">
                                <span class="form-control">所有代理人</span>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="col-md-4 text-right control-label">月份</label>
                        <div class="col-md-4">
                            <span class="form-control" id="current-month"></span>
                            <input type="hidden" name="month" id="current-month-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 text-right control-label">现有任务</label>
                        <div class="col-md-4">
                            <span class="form-control" id="current-money"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="money" class="col-md-4 text-right control-label">额度</label>
                        <div class="col-md-4">
                            <input type="text" name="money" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="form-submit-month" class="btn btn-success">确认提交</button>
            </div>
        </div>
    </div>
    <div class="md-modal md-effect-8 md-hide" id="modal-9">
        <div class="md-content">
            <div class="modal-header">
                <button class="md-close close">×</button>
                <h4 class="modal-title">任务追加</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form-task" action='{{ route('backend.task.store') }}' class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-4 text-right control-label">现有任务</label>
                        <div class="col-md-4">
                            <span class="form-control">{{ format_money($result4) }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="money" class="col-md-4 text-right control-label">额度</label>
                        <div class="col-md-4">
                            <input type="text" name="money" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="money" class="col-md-4 text-right control-label">时间</label>
                        <div class="col-md-4">
                            <select name="type" class="form-control">
                                <option value="0">年任务</option>
                                <option value="1">季度任务</option>
                                <option value="2">月任务</option>
                            </select>
                        </div>
                    </div>
                    <div id="tr-type-1" hidden class="form-group">
                        <label for="money" class="col-md-4 text-right control-label">选择季度</label>
                        <div class="col-md-4">
                            <select multiple name="season[]" class="form-control">
                                <option value="1">第一季度</option>
                                <option value="2">第二季度</option>
                                <option value="3">第三季度</option>
                                <option value="4">第四季度</option>
                            </select>
                        </div>
                    </div>
                    <div id="tr-type-2" hidden class="form-group">
                        <label for="money" class="col-md-4 text-right control-label">选择月份</label>
                        <div class="col-md-4">
                            <select multiple name="months[]" class="form-control">
                                @for($i=1; $i<=12; $i++)
                                    <option value="{{ $i }}">第{{ $i }}月份</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="form-submit" class="btn btn-success">确认提交</button>
            </div>
        </div>
    </div>
    <div class="md-overlay"></div>
@endsection
@section('foot-js')
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/r_backend/js/echarts.js"></script>
    <script charset="utf-8" src="/r_backend/js/modernizr.custom.js"></script>
    <script charset="utf-8" src="/r_backend/js/classie.js"></script>
    <script charset="utf-8" src="/r_backend/js/modalEffects.js"></script>
    <script>
        $(function () {
            var all_agents = '{!! $agents !!}';
            all_agents = JSON.parse(all_agents);
            $('#select-ditch').on('change', function () {
                var ditch_id = $(this).val();
                location.href = '?ditch=' + ditch_id;
            });
            @if (isset($selected_ditch['id']))
                var agents = all_agents['{{ $selected_ditch['id'] }}'];
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

            var should_done = [];
            @foreach($result1 as $key => $item)
                should_done['{{ $key }}'] = '{{ $item['money'] }}';
                    @endforeach
            var have_done = [];
            @foreach($result2 as $key => $item)
                have_done['{{ $key }}'] = '{{ $item['money'] }}';
                    @endforeach
            var total_change = [];
            @foreach($result5 as $key => $item)
                total_change['{{ $key }}'] = '{{ $item['money'] }}';
            @endforeach
            // echarts
            var myChart = echarts.init(document.getElementById('main-echarts'));
            // 指定图表的配置项和数据
            var option = {
                title: {
                    text: '任务完成情况'
                },
                tooltip: {
                    formatter: "{a} <br/>{b}: ¥ {c}"
                },
                legend: {
                    data:['总量变化', '应完成（点击追加任务）','实际完成']
                },
                xAxis: [
                    {
                        type: 'category',
                        data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                        axisPointer: {
                            type: 'shadow'
                        }
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        name: '',
                        min: 0,
                        max: '{{ max($max, $result4) }}',
                        interval: parseInt('{{ max($max, $result4) / 20 }}'),
                        axisLabel: {
                            formatter: '¥ {value}'
                        }
                    },
                ],
                series: [
                    {
                        name:'总量变化',
                        type:'line',
                        stack: '总量',
                        areaStyle: {normal: {}},
                        data: total_change
                    },
                    {
                        name:'应完成（点击追加任务）',
                        type:'bar',
                        data: should_done
                    },
                    {
                        name:'实际完成',
                        type:'bar',
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

                $('#task-month-button').trigger('click');

                $('#form-submit-month').on('click', function () {
                    $('#form-task-month').submit();
                });
            });

            $('#form-submit').on('click', function () {
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
                    $('#current-money').text('¥' + param.value);
                    $('#task-month-button').trigger('click');
                    $('#form-submit-month').on('click', function () {
                        $('#form-task-month').submit();
                    });
                }
            }
            myChart.on('click', eConsole);
        });
    </script>
@endsection
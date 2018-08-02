@if (session('status'))
    <div class="modal fade in" id="success" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-alert" role="document">
            <div class="modal-content">
                <div class="modal-header notitle">
                    <button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
                </div>
                <div class="modal-body" style="padding-bottom: 50px">
                    <i class="iconfont icon-duihao"></i>
                    <p>{{ session('status') }}</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#success').modal('show');
        $('.refresh_close').on('click',function () {
            location.href = location;
        })
    </script>
@endif
@if (count($errors) > 0)
    <div class="tip-wrapper show-error">
        <div class="modal modal-tip fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-guanbi"></i></button>
                        <h4 class="modal-title">提示</h4>
                    </div>
                    <div class="modal-body">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary error-click" data-dismiss="modal">确定</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
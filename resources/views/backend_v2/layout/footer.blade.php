<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/echarts.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.zh-CN.js')}}"></script>
<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
<script>
    $(function() {
        setTimeout(function () {
            $(".show-success").fadeOut("slow");
        }, 2000);
        $("#error-click").click(function(){
            $(".show-error").fadeOut("slow");
        })
        $('.refresh_close').on('click',function () {
            location.href = location;
        })
    })
</script>
@section('footer-more')@show
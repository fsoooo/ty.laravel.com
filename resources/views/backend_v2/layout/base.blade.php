<!DOCTYPE html>
<html>
@include('backend_v2.layout.head')

<body>
<div class="header">
    <div class="logo-wrapper">
        <a href="{{url('/backend')}}"><img src="{{asset('r_backend/v2/img/logo.png')}}" alt="" /></a>
    </div>

    <div class="user-wrapper">
        <button class="user-name"  data-toggle="modal"  data-target="#passwordModal">{{Auth::guard('admin')->user()->name}}</button>
        <a href="{{url('backend/logout')}}"><button class="btn btn-default">退出</button></a>
    </div>

    @yield('top_menu')

</div>
@include('backend_v2.layout.left')
@yield('main')
@include('backend_v2.layout.alert')
@include('backend_v2.layout.footer')



{{--修改密码--}}
<div class="modal fade" id="passwordModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-guanbi"></i></button>
                <h4 class="modal-title">修改密码</h4>
            </div>

            <div class="modal-body">
                <ul>
                    <li><label>旧密码：</label> <input type="password" class="form-control" id="old_name"  placeholder="请输入旧密码"></li>
                    <li><label>新密码：</label> <input type="password" class="form-control" id="new_name"  placeholder="请输入新密码"></li>
                    <li><label>确认密码：</label> <input type="password" class="form-control" id="two_name" placeholder="请再次确认密码"></li>
                </ul>
            </div>

            <div class="modal-footer">
                <button id="modify" class="btn btn-primary" disabled>确认修改</button>
            </div>

        </div>
    </div>
</div>




</body>

</html>

<script>
    var Ele = {
        inputs : $('#passwordModal input'),
        btn : $('#passwordModal .btn')
    }
    Ele.inputs.bind('input propertychange', function() {
        Ele.inputs.each(function(index){
            if(!$(this).val()){
                Ele.btn.prop('disabled',true);
                return false;
            }
            if(index == Ele.inputs.length-1){
                Ele.btn.prop('disabled',false);
            }
        })
    });

    $("#modify").click(function(){
        old_pwd = $("#old_name").val();
        new_pwd = $("#new_name").val();
        two_pwd = $("#two_name").val();

        $.ajax({
            type: "GET",
            url: "/backend/modify",
            data: {old_pwd:old_pwd,new_pwd:new_pwd,two_pwd:two_pwd},
            success: function(msg){
                if(msg == 1){
                    Mask.alert("成功");
                    $('#passwordModal').modal('hide');
                }else if (msg == 2){
                    Mask.alert("旧密码不正确");
                }else if (msg == 3){
                    Mask.alert("两次密码不一致");
                }else if (msg == 4){
                    Mask.alert("修改失败");
                }
            }
        });
    })

</script>







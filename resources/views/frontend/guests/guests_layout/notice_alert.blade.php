{{--成功提示--}}
@if(session('status'))
    <script>
        $(function(){
            Mask.alert("{{session('status')}}");
        });
    </script>
@endif
{{--错误提示--}}
@if(count($errors)>0)
@foreach ($errors->all() as $error)
<script>
    $(function(){
        Mask.alert("{{$error}}");
    });
</script>
@endforeach
@endif



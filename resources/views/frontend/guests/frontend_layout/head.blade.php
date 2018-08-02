<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>天眼互联-科技让保险无限可能</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <meta name="csrf-token" content="{{ csrf_token() }}">





    {{--<link rel="stylesheet" type="text/css" href="/r_backend/css/bootstrap/bootstrap.min.css"/>--}}



    <link rel="stylesheet" href="{{ asset(config('resource.position.css').'/frontend/common.css') }}">


    {{--侧边栏--}}
    <link rel="stylesheet" href="{{ asset(config('resource.position.css').'/frontend/aside.css') }}">
    {{--底端--}}
    {{--<link rel="stylesheet" href="{{ url('css/frontend/footer.css') }}">--}}

    <script src="{{ asset(config('resource.position.js').'/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset(config('resource.position.js').'/frontend/aside.js') }}"></script>
    <script src="{{ asset(config('resource.position.js').'/frontend/birthday.js') }}"></script>


    @yield('css')
    @yield('js')
</head>
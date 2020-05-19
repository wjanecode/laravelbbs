<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--csrf_token-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--style-->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <title>@yield('title','')-switch论坛</title>
</head>
<body>
<!--自定义函数获取路由名称来赋对应的class样式-->
<div id="app" class="{{ route_class() }}-page">
    <!--头部模块-->
    @include('layouts.header')
    <div class="container">
        <!--消息-->
        @include('share.message')
        <!--内容-->
        @yield('content')
    </div>
    <!--底部模块-->
    @include('layouts.footer')
</div>
<!--script-->
<script type="javascript" src="{{ mix('js/app.js') }}"></script>

</body>
</html>

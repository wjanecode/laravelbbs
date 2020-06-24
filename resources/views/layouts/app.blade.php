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
    @yield('style')
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" ></script>


    <title>@yield('title','首页')-switch论坛</title>
    <meta name="description" content="@yield('description', 'switch 爱好者社区')" />
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

{{--开启多用户登录切换,单独放出来,放到上面div里面报错---}}
@if (app()->isLocal())
    @include('sudosu::user-selector')
@endif

<script>
    //下拉菜单
    $('.dropdown-toggle').dropdown();

    //初始化vue
    const app = new Vue({
        el: '#app',
    });


</script>
@yield('js')

</body>
</html>

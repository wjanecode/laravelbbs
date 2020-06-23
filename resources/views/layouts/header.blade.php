<nav class="navbar navbar-expand-md navbar-dark  bg-dark">
    <a class="navbar-brand" href="#">Fixed navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a class="nav-link @if(request()->url() ===  route('posts.index')) active @endif" href="{{ route('posts.index') }}">首页<span class="sr-only">(current)</span></a>
            </li>
            @foreach(\App\Models\Category::all() as $cate)
            <li class="nav-item @if(request()->url() === route('categories.show',$cate->id)) active @endif">
                <a class="nav-link" href="{{ route('categories.show',['category'=>$cate->id,'order'=>'reply']) }}">{{$cate->name}}</a>
            </li>
            @endforeach

        </ul>
        <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-auto" type="text" placeholder="搜索" aria-label="搜索">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">搜索</button>
        </form>

        <ul class="navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if( !Auth::check())
                <div class="">
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
                </div>

            @else
            <div>
                <a class="nav-link mr-2 ml-2 " style="color: red" href="{{ route('notifications.index') }}">
                    未读 * {{ Auth::user()->notification_count }}
                </a>
            </div>
            <div class="dropdown open mr-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('users.show',Auth::id()) }}">个人中心</a>
                    <a class="dropdown-item" href="{{ route('logout') }}">注销</a>
                </div>
            </div>


            @endif
        </ul>

    </div>



</nav>








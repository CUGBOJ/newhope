<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title','default')</title>
<link rel="stylesheet" href="/css/default.css">
</head>
<body>
<header class="navbar navbar-fixed-top navbar-inverse">
    <nav>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="/">主页</a></li>
            <li><a href="/help">帮助</a></li>
            <li><a href="/about">关于</a></li>
            <li><a href="/signup">注册</a></li>
            <li><a href="/signin">登陆</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    @yield('content')
</div>
</body>
</html>
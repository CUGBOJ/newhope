<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title','default')</title>
<link rel="stylesheet" href="/css/default.css">
</head>
<body>
@include('layout._header')
<div>
    @include('share._message')
    <div class="container">
        @yield('content')
    </div>
</div>
@include('layout._footer')
</body>
</html>
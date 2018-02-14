<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>@yield('title','default')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
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
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
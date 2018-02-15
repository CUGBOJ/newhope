<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>@yield('title','default')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
<div>
    @include('share._message')
    <div class="layout" id="app" v-cloak>
        <layout>
            @include('layout._header')
            <i-content :style="{margin: '88px 20px 0', background: '#fff', minHeight: '500px'}">
                @yield('content')
            </i-content>
            @include('layout._footer')
        </layout>
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
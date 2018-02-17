<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" style="display: none">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','default')</title>
</head>
<body>
<div>
    @include('share._message')
    <div class="layout" id="app" v-cloak>
        <layout>
            @include('layout._header')
            <card style="height: 80vh; margin: 80px 30px 0; overflow: auto;" dis-hover>
                @yield('content')
            </card>
            @include('layout._footer')
        </layout>
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
</body>
</html>
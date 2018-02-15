@extends('layout.default')
@section('title', '登录')

@section('content')
    <div>
        <h1>登录</h1>
        @include('share._error')
        <form action="{{ route('login') }}" method="POST" style="width: 50%;">
            {{ csrf_field() }}
            <i-input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="Username">
                <Icon type="ios-person-outline" slot="prepend"></Icon>
            </i-input>
            <i-input type="password" name="password" id="password" placeholder="Password">
                <Icon type="ios-locked-outline" slot="prepend"></Icon>
            </i-input>
            <button-group>
                <i-button html-type="submit">Login</i-button>
                <i-button html-type="reset">Reset</i-button>
            </button-group>
        </form>
    </div>
@stop
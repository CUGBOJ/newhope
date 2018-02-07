@extends('layout.default')
@section('title', '更新个人资料')
@section('content')
    <h3>更新个人资料</h3>
    <div>
        @include('share._error')
        <form method="POST" action="{{ route('users.update', $user->id )}}">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
            <div>
                <label for="name">用户名：</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            </div>
            <div>
                <label for="email">邮箱：</label>
                <input type="text" name="email" class="form-control" value="{{ $user->email }}" disabled>
            </div>
            <div>
                <label for="password">密码：</label>
                <input type="password" name="password" class="form-control" value="{{ old('password') }}">
            </div>
            <div>
                <label for="password_confirmation">确认密码：</label>
                <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
            </div>
            <button type="submit" class="btn btn-primary">修改</button>

        </form>
    </div>

@extends('layout.default')
@section('title', '更新个人资料')
@section('content')
    <h3>更新个人资料</h3>
    <div>
        @include('share._error')
        <form method="POST" action="{{ route('users.update', $user->username )}}"  accept-charset="UTF-8" enctype="multipart/form-data">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="" class="avatar-label">用户头像</label>
                <input type="file" name="avatar">
                @if($user->avatar)
                    <br>
                    <img  src="{{ url(route('home')).$user->avatar }}" width="200" />
                @endif
            </div>
            <div>
                <label for="nickname">昵称：</label>
                <input type="text" name="nickname" class="form-control" value="{{ $user->nickname }}">
            </div>
            <div>
                <label for="email">邮箱：</label>
                <input type="text" name="email" class="form-control" value="{{ $user->email }}">
            </div>
            <div>
                <label for="password">密码：</label>
                <input type="password" name="password" class="form-control" >
            </div>
            <div>
                <label for="password_confirmation">确认密码：</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div>
                <label for="school">学校：</label>
                <input type="text" name="school" class="form-control" value="{{ $user->school }}">
            </div>
            <button type="submit" class="btn btn-primary">修改</button>

        </form>
    </div>
@stop

@extends('layout.default')
@section('title', '创建题目')

@section('content')
    <div>
        <h1>创建题目</h1>
        @include('share._error')
        <form action="{{ route('problems.store') }}"  method="POST" style="margin: 200px 600px" id="createproblem">
            {{ csrf_field() }}
            <button type="submit">提交</button>
        </form>
        <div>
            <label for="title">Title：</label>
            <textarea name="title" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
            <label for="description">Description：</label>
            <textarea name="description" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>

            <label for="input">Input：</label>
            <textarea name="input" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
            <label for="output">Output：</label>
            <textarea name="output" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
            <label for="sample_input">Sample Input:</label>
            <textarea name="sample_input" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
            <label for="sample_output">Sample Output:</label>
            <textarea name="sample_output" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
            <label for="hint">Hint:</label>
            <textarea name="hint" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
        <label for="author">Author:</label>
        <textarea name="author" id="" cols="30" rows="10" form="createproblem">

        </textarea>
        </div>
    </div>
@stop



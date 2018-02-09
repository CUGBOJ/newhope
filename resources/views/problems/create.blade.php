
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
            <label for="Title">Title：</label>
            <textarea name="Title" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
            <label for="Description">Description：</label>
            <textarea name="Description" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>

            <label for="Input">Input：</label>
            <textarea name="Input" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
            <label for="Output">Output：</label>
            <textarea name="Output" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
            <label for="Sample_input">Sample Input:</label>
            <textarea name="Sample_input" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
            <label for="Sample_output">Sample Output:</label>
            <textarea name="Sample_output" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
            <label for="Hint">Hint:</label>
            <textarea name="Hint" id="" cols="30" rows="10" form="createproblem">

        </textarea>
            <br>
        <label for="Author">Author:</label>
        <textarea name="Author" id="" cols="30" rows="10" form="createproblem">

        </textarea>
        </div>
    </div>
@stop



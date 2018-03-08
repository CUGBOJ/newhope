@extends('layout.default')
@section('title', '更新题目')
@section('content')
    <h3>更新题目</h3>
    <div>
        @include('share._error')
        <form method="POST" action="{{ route('problems.update', $problem->id )}}" id="editproblem">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">修改</button>
        </form>
        <label for="title">Title：</label>
        <textarea name="title" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->title }}
        </textarea>
        <br>
        <label for="description">Description：</label>
        <textarea name="description" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->description }}
        </textarea>
        <br>

        <label for="input">Input：</label>
        <textarea name="input" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->input }}
        </textarea>
        <br>
        <label for="output">Output：</label>
        <textarea name="output" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->output }}
        </textarea>
        <br>
        <label for="sample_input">Sample Input:</label>
        <textarea name="sample_input" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->sample_input }}
        </textarea>
        <br>
        <label for="sample_output">Sample Output:</label>
        <textarea name="sample_output" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->sample_output }}
        </textarea>
        <br>
        <label for="hint">Hint:</label>
        <textarea name="hint" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->hint }}
        </textarea>
        <label for="author">Author:</label>
        <textarea name="author" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->Author }}
        </textarea>
        <br>
    </div>

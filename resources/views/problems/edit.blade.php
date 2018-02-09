@extends('layout.default')
@section('title', '更新个人资料')
@section('content')
    <h3>更新题目</h3>
    <div>
        @include('share._error')
        <form method="POST" action="{{ route('problems.update', $problem->id )}}" id="editproblem">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">修改</button>
        </form>
        <label for="Title">Title：</label>
        <textarea name="Title" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->Title }}
        </textarea>
        <br>
        <label for="Description">Description：</label>
        <textarea name="Description" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->Description }}
        </textarea>
        <br>

        <label for="Input">Input：</label>
        <textarea name="Input" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->Input }}
        </textarea>
        <br>
        <label for="Output">Output：</label>
        <textarea name="Output" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->Output }}
        </textarea>
        <br>
        <label for="Sample_input">Sample Input:</label>
        <textarea name="Sample_input" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->Sample_input }}
        </textarea>
        <br>
        <label for="Sample_output">Sample Output:</label>
        <textarea name="Sample_output" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->Sample_output }}
        </textarea>
        <br>
        <label for="Hint">Hint:</label>
        <textarea name="Hint" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->Hint }}
        </textarea>
        <label for="Author">Author:</label>
        <textarea name="Author" id="" cols="30" rows="10" form="editproblem">
             {{ $problem->Author }}
        </textarea>
        <br>
    </div>

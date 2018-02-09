@extends('layout.default')
@section('title', '注册')

@section('content')
    <div>
        @include('share._error')
        <h1> {{$problem->title}}</h1>
        <div>
            <div>
                <h3>Description</h3>
                {{$problem->Description}}
            </div>
            <div>
                <h3>Input</h3>
                {{$problem->Input}}
            </div>
            <div>
                <h3>Output</h3>
                {{$problem->Output}}
            </div>
            <div>
                <h3>Sample_input</h3>
                {{$problem->Sample_input}}
            </div>
            <div>
                <h3>Sample_output</h3>
                {{$problem->Sample_output}}
            </div>
            <div>
                <h3>Hint</h3>
                {{$problem->Hint}}
            </div>
        </div>
    </div>
@stop



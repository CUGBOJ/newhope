@extends('layout.default')
@section('title', '题目展示')

@section('content')
    <div>
        @include('share._error')

        <row>
            <i-col span="12">
                <div style="height: 70vh; overflow: scroll">
                    <h1> {{$problem->Title}}</h1>
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
                <i-button @click="this.window.location.href = '{{ route('problems.edit', $problem->id ) }}'">
                    修改题目
                </i-button>
                <i-button type="text" @click="this.window.location.href = '{{route('topics.index')}}?pro_id={{$problem->id}}'">
                    Discuss
                </i-button>
                <i-button type="primary">
                    提交
                </i-button>
            </i-col>
            <i-col span="12">
                <code-editor></code-editor>
            </i-col>
        </row>
    </div>
@stop



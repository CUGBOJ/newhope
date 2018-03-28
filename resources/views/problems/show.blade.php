@extends('layout.default')
@section('title', '题目展示')

@section('content')
    <div>
        @include('share._error')

        <row>
            <i-col span="12">
                <div style="height: 70vh; overflow: auto">
                    <h1> {{$problem->title}}</h1>
                    <div>
                        <h3>Description</h3>
                        {!! nl2br($problem->description) !!}
                    </div>
                    <div>
                        <h3>Input</h3>
                        {!! nl2br($problem->input) !!}
                    </div>
                    <div>
                        <h3>Output</h3>
                        {!! nl2br($problem->output) !!}
                    </div>
                    <div>
                        <h3>sample_input</h3>
                        {!! nl2br($problem->sample_input) !!}
                    </div>
                    <div>
                        <h3>sample_output</h3>
                        {!! nl2br($problem->sample_output) !!}
                    </div>
                    <div>
                        <h3>hint</h3>
                        {!! nl2br($problem->hint) !!}
                    </div>
                </div>
                <form action="{{route('codesubmit')}}" method="POST"  id="codeform" style="display: inline-block;">
                    {{ csrf_field() }}
                    <i-button type="primary" @click.native="this.window.bus.$emit('submit')">
                        提交
                    </i-button>
                </form>
                <i-button type="text"
                          @click="this.window.location.href = '{{ route('problem.topics', $problem->id) }}'">
                    Discuss
                </i-button>
                <i-button @click="this.window.location.href = '{{ route('problems.edit', $problem->id) }}'">
                    修改题目
                </i-button>
            </i-col>
            <i-col span="12">
                <code-editor>
                </code-editor>
            </i-col>
        </row>
    </div>
@stop



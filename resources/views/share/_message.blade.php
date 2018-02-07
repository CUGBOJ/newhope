
@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(session()->has($msg))
        <div>
            {{ session()->get($msg) }}
        </div>
    @endif
@endforeach
<?php
//include_once "lang_result_define.php";
$results=[
    '',
    'Accepted',
    'WA',
    'PE',
    'TLE',
    'RE',
    'MLE',
    'Output limit',
    'Unknown error',
    'CE',
    'Queuing and Judging',
    'hh'
];
$langs=[
    '',
    'C',
    'C++',
    'JAVA',
    'Python 2',
    'Python 3',
    'C#',
    'Ruby',
    'Pascal',
];
?>
<li>

    {{ $status->id }}
    ||
    <?php
    echo $results[$status->Result];
    ?>
    ||
    {{$status->Username}}
    ||
    {{$status->Problem_id}}
    ||
    {{ $status->Time }}
    ||
    {{ $status->Memory }}
    ||
    {{ $status->Length}}
    ||
    <?php
     echo $langs[$status->Lang];
    ?>

    ||
    {{$status->Submit_time}}

    {{--@can('destroy', $user)--}}
    {{--<form action="{{ route('users.destroy', $user->id) }}" method="post">--}}
    {{--{{ csrf_field() }}--}}
    {{--{{ method_field('DELETE') }}--}}
    {{--<button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>--}}
    {{--</form>--}}
    {{--@endcan--}}
</li>
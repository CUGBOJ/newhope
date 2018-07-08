<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Contest::class, function (Faker $faker) {
    static $password;

    $end_time = $faker ->dateTimeThisMonth();
    $start_time = $faker ->dateTimeThisMonth($end_time);
    $isprivate = $faker -> boolean;
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'start_time'=>$start_time,
        'end_time'=>$end_time,
        'lock_board_time'=>$faker ->dateTimeThisMonth($end_time),
        'password'=> !$isprivate ?null:$password = bcrypt('secret'),
        'title' => $faker ->sentence,
        'description' => $faker -> sentence,
        'isprivate'=> $isprivate,
        'hide_other' => $faker -> boolean,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});

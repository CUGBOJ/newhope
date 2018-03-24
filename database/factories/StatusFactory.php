<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Status::class, function (Faker $faker) {
    $time = $faker->dateTimeThisMonth();
    $code = $faker->text;

    return [
        'result' => $faker->numberBetween(1, 11),
        'time' => $faker->numberBetween(0, 2500),
        'code' => $code,
        'memory' => $faker->numberBetween(0, 65535),
        'length' => strlen($code),
        'lang' => $faker->numberBetween(1, 9),
        'submit_time' => $time,
        'be_judged' => true,
    ];
});

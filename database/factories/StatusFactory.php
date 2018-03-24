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

    return [
        'result' => $faker->numberBetween(1, 11),
        'time' => $faker->numberBetween(0, 2500),
        'memory' => $faker->numberBetween(0, 65535),
        'length' => $faker->numberBetween(100, 3000),
        'lang' => $faker->numberBetween(1, 8),
        'submit_time' => $time,
        'code' => $faker->text,
        'be_judged' => true,
    ];
});

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
       'Result'=>$faker->numberBetween(1, 11),
        'Time'=>$faker->numberBetween(0,2500),
        'Memory'=>$faker->numberBetween(0,65535),
        'Length'=>$faker->numberBetween(100,3000),
        'Lang'=>$faker->numberBetween(1,8),
        'Submit_time'=> $time,
    ];
});

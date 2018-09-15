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

$factory->define(App\Models\Problem::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'title' => "Problem ",
        'description' => $faker->text,
        'input'=>$faker->text,
        'output'=>$faker->text,
        'sample_input'=>$faker->text,
        'sample_output'=>$faker->text,
        'author'=>$faker->name,
        'hint'=>$faker->sentence,
        'hide'=>$faker->boolean,

        'time_limit'=>1000,
        'memory_limit'=>65535,
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});

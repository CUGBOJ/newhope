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
        'Title' => $faker->sentence,
        'Description' => $faker->text,
        'Input'=>$faker->text,
        'Output'=>$faker->text,
        'Sample_input'=>$faker->text,
        'Sample_output'=>$faker->text,
        'Author'=>$faker->name,
        'Hint'=>$faker->sentence,

        'AC_number'=>0,
        'Submit_number'=>0,
        'AC_user_number'=>0,
        'Submit_user_number'=>0,
        'Time_limit'=>1000,
        'Memory_limit'=>65535,
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});

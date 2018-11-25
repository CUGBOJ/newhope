<?php

use Faker\Generator as Faker;
use App\Http\Controllers\TeamsController;

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


$factory->define(App\Models\Team::class, function (Faker $faker) {
    

    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);


 
    return [
        'teamname' => $faker->name,
        'created_at' => $created_at,
        'updated_at' => $updated_at,   
    ];
});

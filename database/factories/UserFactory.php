<?php

use Faker\Generator as Faker;
use App\Http\Controllers\UsersController;

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


$factory->define(App\Models\User::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    static $password;

    $usersController = new UsersController();

    $nickname = $faker->name;
    return [
        'username' => $faker->name,
        'nickname' => $nickname,
        'email' => $faker->safeEmail,
        'school' => $faker->name,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'register_time' => $date_time,
        'last_login_time' => $date_time,
        'last_login_ip' => $faker->ipv4,
        'avatar' => $usersController->regenerate_avatar($nickname),
    ];
});

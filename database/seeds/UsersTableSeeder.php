<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());
        $user = User::find(1);
        $user->username='laravel';
        $user->nickname = 'Aufree';
        $user->email = 'fuck@fuck.com';
        $user->school =  'CUGB';
        $user->password = bcrypt('password');
        $user->is_admin = true;
        $user->save();
    }
}
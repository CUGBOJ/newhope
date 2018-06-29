<?php

use App\Models\User;
use Illuminate\Database\Seeder;

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

        $user = User::find(2);
        $user->username = 'laravel';
        $user->nickname = 'Aufree';
        $user->email = 'fuck@fuck.com';
        $user->school = 'CUGB';
        $user->password = bcrypt('password');
        $user->assignRole('root');
        $user->save();

        $user = User::find(1);
        $user->username = 'all';
        $user->nickname = 'all';
        $user->email = 'all@all.com';
        $user->school = 'all';
        $user->password = bcrypt('never');
        $user->assignRole('admin');
        $user->save();

    }
}

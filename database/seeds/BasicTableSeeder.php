<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class BasicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(2)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->makeHidden(['can'])->toArray());

        $user = User::find(2);
        $user->username = 'laravel';
        $user->email = 'admin@cugbacm.org';
        $user->school = 'CUGB';
        $user->password = bcrypt('password');
        $user->assignRole('root');
        $user->save();

        $user = User::find(1);
        $user->username = 'all';
        $user->email = 'all@all.com';
        $user->school = 'all';
        $user->password = bcrypt('password');
        $user->assignRole('admin');
        $user->save();

    }
}

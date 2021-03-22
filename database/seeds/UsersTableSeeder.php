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
        $users = factory(User::class)->times(100)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->makeHidden(['can'])->toArray());
    
        $user = User::find(1);
        $user->username = 'admin';
        $user->nickname = 'cugbacm';
        $user->email = 'acm@cugb.edu.cn';
        $user->school = 'CUGB';
        $user->password = bcrypt('password');
        $user->assignRole('admin');
        $user->save();

    }
}

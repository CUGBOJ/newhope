<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;


class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //============User================

        $permission = Permission::create([
            'name' =>'user_destroy',
            'description'=> 'User Model Destroy'
        ]);

        //============Problem=============

        $permission = Permission::create([
            'name' =>'problem_create',
            'description'=> 'Problem Model Create'
        ]);

        $permission = Permission::create([
            'name' =>'problem_edit',
            'description'=> 'Problem Model Edit'
        ]);

        $permission = Permission::create([
            'name' =>'problem_destroy',
            'description'=> 'Problem Model Destroy'
        ]);

        //============Topic==============

        $permission = Permission::create([
            'name' =>'topic_create',
            'description'=> 'Topic Model Create'
        ]);

        $permission = Permission::create([
            'name' =>'topic_edit',
            'description'=> 'Topic Model Edit'
        ]);

        $permission = Permission::create([
            'name' =>'topic_destroy',
            'description'=> 'Topic Model Destroy'
        ]);

        //============Reply==============

        $permission = Permission::create([
            'name' =>'reply_create',
            'description'=> 'Reply Model Create'
        ]);

        $permission = Permission::create([
            'name' =>'reply_destroy',
            'description'=> 'Reply Model Destroy'
        ]);

        //============Contest=============

        $permission = Permission::create([
            'name' =>'contest_create',
            'description'=> 'Contest Model Create'
        ]);

        $permission = Permission::create([
            'name' =>'contest_edit',
            'description'=> 'Contest Model Edit'
        ]);

        $permission = Permission::create([
            'name' =>'contest_destroy',
            'description'=> 'Contest Model Destroy'
        ]);

        //==========Announcement==========

        $permission = Permission::create([
            'name' =>'announcement_create',
            'description'=> 'Announcement Model Create'
        ]);

        $permission = Permission::create([
            'name' =>'announcement_edit',
            'description'=> 'Announcement Model Edit'
        ]);

        $permission = Permission::create([
            'name' =>'announcement_destroy',
            'description'=> 'Announcement Model Destroy'
        ]);

        //=======Permission_Manage=======

        $permission = Permission::create([
            'name' =>'permission_manage',
            'description'=> 'manage roles permission',
        ]);


    }
}
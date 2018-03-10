<?php

use Illuminate\Database\Seeder;
use App\Models\Role;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'Root',
            'description' => 'Highest Authority',
        ]);
        for ($i = 1; $i <= 17; $i++) {
            $role->Permission()->attach($i);
        }

        $role = Role::create([
            'name' => 'Admin',
            'description' => 'Highest Authority not about User',
        ]);
        for ($i = 2; $i <= 16; $i++) {
            $role->Permission()->attach($i);
        }

        $role = Role::create([
            'name' => 'Topic Admin',
            'description' => 'Can manage Topic',
        ]);
        $role->Permission()->attach(5);
        $role->Permission()->attach(8);
        $role->Permission()->attach(7);
        $role->Permission()->attach(9);

        $role = Role::create([
            'name' => 'Normal',
            'description' => 'Normal user',
        ]);
        $role->Permission()->attach(5);
        $role->Permission()->attach(8);

    }
}
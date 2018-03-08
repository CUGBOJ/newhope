<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Model::unguard();
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            ProblemsTableSeeder::class,
            UsersTableSeeder::class,
            StatusesTableSeeder::class,
            TopicsTableSeeder::class,
            ReplysTableSeeder::class,
            AnnouncementsTableSeeder::class,
            ContestsTableSeeder::class,
        ]);
        Model::reguard();
    }
}
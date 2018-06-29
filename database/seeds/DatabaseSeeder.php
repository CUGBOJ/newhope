<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        $this->call([
            ProblemsTableSeeder::class,
            UsersTableSeeder::class,
            StatusesTableSeeder::class,
            TopicsTableSeeder::class,
            ReplysTableSeeder::class,
            AnnouncementsTableSeeder::class,
            ContestsTableSeeder::class,
            ContestProblemSeeder::class,
        ]);
        Model::reguard();
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Status;
use App\Models\User;
use App\Models\Problem;
use App\Models\Contest;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
       $this->seedNormalStatus();
       $this->seedContestStatus();
    }

    public function seedNormalStatus()
    {
        $user_names = User::all()->pluck('username')->toArray();
        $pids = Problem::all()->pluck('id')->toArray();
        $faker = app(Faker\Generator::class);

        $statuses = factory(Status::class)
            ->times(2000)
            ->make()
            ->each(function ($status) use ($user_names, $pids, $faker) {
                $pid = $faker->randomElement($pids);
                $username = $faker->randomElement($user_names);

                $status->username = $username;
                $status->pid = $pid;
            });

        Status::insert($statuses->toArray());
    }

    public function seedContestStatus() {

    }
}

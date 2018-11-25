<?php

use Illuminate\Database\Seeder;
use App\Models\Contest;
use App\Models\User;
use App\Models\Status;
use App\Models\Problem;

class ContestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all()->pluck('username','id')->toArray();
        $faker = app(Faker\Generator::class);
        $users2= User::all()->pluck('id','username')->toArray();


        factory(Contest::class)
            ->times(5)
            ->create()
            ->each(function ($contest, $index)
            use ($users, $faker,$users2) {
                $userList=$faker->randomElements($users,50);
                $contest->id = $index + 1;
                $problems = Problem::all()->random(10);
                $keychar = 1;
                foreach ($problems as $problem) {
                    $contest->problems()->attach($problem, ['contest_id' => $contest->id,
                        'keychar' => $keychar++,
                        'color' => $faker->colorName]);
                }

                $contest->status()->saveMany(factory(Status::class, 50)->make()->each(function ($status)
                use ($faker, $userList, $contest, $problems) {
                    $status->username = $faker->randomElement($userList);
                    $status->submit_time = $faker->dateTimeBetween($contest->start_time, $contest->end_time);
                    $status->pid = $faker->randomElement($problems)->id;
                }));
                foreach($userList as $user){
                    $contest->users()->attach($users2[$user]);
                }
            });
    }
}

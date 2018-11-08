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
        $user_names = User::all()->pluck('username')->toArray();
        $pids = Problem::all()->pluck('id')->toArray();
        $faker = app(Faker\Generator::class);

        $statuses = factory(Status::class)
            ->times(2000)
            ->make()
            ->each(function ($status, $index) use ($user_names, $pids, $faker) {
                $pid=$faker->randomElement($pids);
                $username=$faker->randomElement($user_names);

                $status->username = $username;
                $status->pid = $pid;
                $pro=Problem::find($pid);
                $contests=array();
                foreach($pro->contests as $contest){
                    array_push($contests,$contest->id);
                }
                $cid=$faker->randomElement($contests);
                $status->contest_id=$cid;

            });

        // 将数据集合转换为数组，并插入到数据库中
        Status::insert($statuses->toArray());
    }
}

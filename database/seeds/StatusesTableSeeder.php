<?php

use Illuminate\Database\Seeder;
use App\Models\Status;
use App\Models\User;
use App\Models\Problem;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user_names = User::all()->pluck('username')->toArray();
        $problem_ids=Problem::all()->pluck('id')->toArray();
        $faker = app(Faker\Generator::class);

        $statuses = factory(Status::class)
            ->times(1000)
            ->make()
            ->each(function ($status, $index)
            use ($user_names, $problem_ids, $faker)
            {
                // 从用户名 数组中随机取出一个并赋值
                $status->Username= $faker->randomElement($user_names);

                // 问题 ID，同上
                $status->Problem_id = $faker->randomElement($problem_ids);
            });

        // 将数据集合转换为数组，并插入到数据库中
        Status::insert($statuses->toArray());

    }
}

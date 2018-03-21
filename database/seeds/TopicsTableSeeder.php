<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Problem;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $usernames = User::all()->pluck('username')->toArray();
        $pids = Problem::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)
            ->times(100)
            ->make()
            ->each(function ($topic, $index)
            use ($usernames, $pids, $faker)
            {
                // 从用户 ID 数组中随机取出一个并赋值
                $topic->username = $faker->randomElement($usernames);
                $topic->last_reply_username=$topic->username;

                // 话题分类，同上
                $topic->pid = $faker->randomElement($pids);
            });

        // 将数据集合转换为数组，并插入到数据库中
        Topic::insert($topics->toArray());
    }
}

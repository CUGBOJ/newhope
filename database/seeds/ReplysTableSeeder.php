<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Reply;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        $usernames = User::all()->pluck('username')->toArray();
        $topic_ids = Topic::all()->pluck('id')->toArray();
        $faker = app(Faker\Generator::class);

        $replys = factory(Reply::class)
            ->times(1000)
            ->make()
            ->each(function ($reply, $index)
            use ($usernames, $topic_ids, $faker)
            {
                $reply->username= $faker->randomElement($usernames);
                $reply->topic_id = $faker->randomElement($topic_ids);
            });
        Reply::insert($replys->toArray());
    }
}
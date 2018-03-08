<?php

use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $announcements = factory(Announcement::class)
            ->times(100)
            ->make();
        // 将数据集合转换为数组，并插入到数据库中
        Announcement::insert($announcements->toArray());
    }
}

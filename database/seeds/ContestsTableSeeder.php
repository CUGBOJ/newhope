<?php

use Illuminate\Database\Seeder;
use App\Models\Contest;
use App\Models\User;

class ContestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $owner = User::all()->pluck('username')->toArray();
        $faker = app(Faker\Generator::class);
        $contests = factory(Contest::class)
            ->times(20)
            ->make()
            ->each(function ($contest,$index)
                use ($owner,$faker)
            {
                $contest->owner=$faker->randomElement($owner);
            });
        Contest::insert($contests->makeVisible(['password'])->toArray());
   //     Contest::insert($contests->toArray());
    }
}

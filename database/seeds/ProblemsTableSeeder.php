<?php

use Illuminate\Database\Seeder;
use App\Models\Problem;

class ProblemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $problems = factory(Problem::class, 50)->create();
    }
}

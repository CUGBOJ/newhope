<?php

use Illuminate\Database\Seeder;
use App\Models\Problem;

class ProblemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $problems = factory(Problem::class, 50)->create();
    }
}

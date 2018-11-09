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
        $problems = factory(Problem::class)
            ->times(150)
            ->make();
        $i=1;
        foreach($problems as $problem){
            $problem->title=$problem->title.(string)$i;
            $i++;
        }
        Problem::insert($problems->toArray());
    }
}

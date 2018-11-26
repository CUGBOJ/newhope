<?php

use Illuminate\Database\Seeder;
use App\Models\Contest;
use App\Models\User;
use App\Models\Status;
use App\Models\Team;
use App\Models\Problem;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        
        $contests= Contest::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);
        
        $teams = factory(Team::class)
            ->times(100)
            ->make()
            ->each(function ($team,$index) use ($contests, $faker) {
                $contest_id=$faker->randomElement($contests);
                $team->contest_id=$contest_id;
                $contest=Contest::find($contest_id);
                $users=$contest->users->pluck('id')->toArray();
                $num=random_int(1,4);
                $tmp=\DB::table('contest_user')->where('contest_id',$contest_id)->get()->toArray();
                $userList=$faker->randomElements($tmp,$num);
                $i=0;
                foreach($userList as $item){
                    if($item->team_id==null){
                        if($i==0){
                            $team->captain=$item->user_id;
                        }
                        \DB::table('contest_user')->where('contest_id',$contest_id)->where('user_id',$item->user_id)->update(['team_id' => $index+1]);
                        \DB::table('team_user')->insert(['team_id'=>$index,'user_id'=>$item->user_id]);
                        $i++;
                    }
                }
                if($i==0){
                    $tmp=\DB::table('contest_user')->where('contest_id',$contest_id)->where('team_id',null)->get()->toArray();
                    $item=$faker->randomElement($tmp);
                    $team->captain=$item->user_id;
                    \DB::table('contest_user')->where('contest_id',$contest_id)->where('user_id',$item->user_id)->update(['team_id' => $index+1]);
                    \DB::table('team_user')->insert(['team_id'=>$index,'user_id'=>$item->user_id]);
                    $i++;
                }
            
            });

        Team::insert($teams->toArray());
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;
use App\Notifications\TeamApplyReplied;
use Illuminate\Support\Facades\Auth;



class TeamsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'teamname' => 'required|max:50',
        ]);
        
        $team = Team::create([
            'teamname' => $request->teamname,
            'captain' =>Auth::user()->id,
        ]);

        return response()->json($team);
    }

     public function addMember(Team $team,Request $request)
     {
        $userId=$request->userId;
        \DB::table('contest_user')->where('contest_id'.$team->contest_id)->where('user_id',$userId)->update(['team_id'=>$team->id]);
        return;
    }

     public function subMember(Team $team,Request $request){
        $userId=$request->userId;
        if($userId==$team->captain){
            DB::table('users')->where('team_id',  $team->id)->update(['team_id'=>null]);
            destroy();
            return;
        }
        
        \DB::table('contest_user')->where('contest_id'.$team->contest_id)->where('user_id',$userId)->where('team_id',$team->id)->update(['team_id'=>null]);
     }

     public function show(Team $team,Request $request){
        return response()->json(['base'=>$team,'grade'=>111]);
     }

     public function getGrade(Team $team){


     }

     public function index(Reqest $request)
     {
         $team = Team::getModel();
         return $team->get();
     }

     public function destroy(Team $team)
     {
         $team->delete();
         return response()->json('Team be destroyed!', 200);
     }

    public function apply(Team $team,Request $request){
        // dd($request);
        \DB::insert('insert into team_apply (user_id,team_id,create_time) values (?, ?,?)', [ Auth::user()->id, $team->id,now()]);
        $user=User::find($team->captain);
        $user->messages(new TeamApplyReplied($team->id,Auth::user()->id));
        $user->save();
        return response()->json(['message' => '申请成功'], 200);

    }

    public function dealApply(Team $team,Request $request){
       dd($team);
        if($request->res==true){
            $user=$request->user;
            \DB::table('contest_user')->where('contest_id',$team->contest_id)->where('user_id',$user)->update('team_id',$team_id);
            \DB::table('team_apply')->where('team_id',$team->id)->where('user_id',$user)->update(['be_deal'=>true,'deal_time'=>now()]);

        }
        else{
            $user=$request->user;
            \DB::table('contest_user')->where('contest_id',$team->contest_id)->where('user_id',$user)->update('team_id',$team_id);
            \DB::table('team_apply')->where('team_id',$team->id)->where('user_id',$user)->delete();
        }
    }

    public function getApplyList(Team $team){
        $applyList=\DB::table('team_apply')->where('team_id',$team->id)->where('be_deal',false)->pluck('user_id')->toArray();
        $applyUser=array();
        foreach($applyList as $i){
            array_push($applyUser,User::find($i));
        }
        return $applyUser;
    }
}

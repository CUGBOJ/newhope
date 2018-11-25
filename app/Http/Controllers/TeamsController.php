<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

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

}

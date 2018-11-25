<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class TeamsController extends Controller
{
     public function store(Request $request){
        $this->validate($request, [
            'teamname' => 'required|max:50',
            'captain' =>'required'
        ]);
        
        $contest = Team::create([
            'teamname' => $request->teamname,
            'captain' =>$request->captain,
        ]);
        return response()->json($team);
     }

     public function addMember(Team $team,Request $request)
     {
        $userId=$request->userId;
        $team->users()->attach($userId);
        $team->member_number++;
        return;
     }

     public function subMember(Team $team,Request $request){
        $userId=$request->userId;
        if($userId==$team->captain){
            destroy();
            return;
        }
        $team->member_number--;
        $user->roles()->detach($roleId);
     }

     public function show(Team $team,Request $request){
        $team->users;
        return response()->json($team);
     }
     public function index(Request $request)
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

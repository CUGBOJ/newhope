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
            'captain' => Auth::user()->id,
        ]);

        return response()->json($team);
    }

    public function addMember(Team $team, Request $request)
    {
        $userId = $request->userId;
        \DB::table('contest_user')->where('contest_id' . $team->contest_id)->where('user_id', $userId)
            ->update(['team_id' => $team->id]);
        return;
    }

    public function subMember(Team $team, Request $request)
    {
        $userId = $request->userId;
        if ($userId == $team->captain) {
            DB::table('users')->where('team_id', $team->id)->update(['team_id' => null]);
            destroy();
            return;
        }

        \DB::table('contest_user')->where('contest_id' . $team->contest_id)->where('user_id', $userId)
            ->where('team_id', $team->id)->update(['team_id' => null]);
    }

    public function show(Team $team, Request $request)
    {
        return response()->json(['base' => $team, 'grade' => $this->getGrade($team)]);
    }

    public function getGrade(Team $team)
    {
        // TODO
        return 0;
    }

    public function index(Reqest $request)
    {
        return Team::all();
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return response()->json('Team be destroyed!', 200);
    }

    public function apply(Team $team, Request $request)
    {   
        $tmp=\DB::table('contest_user')->where('contest_id', $team->contest_id)->where('user_id', Auth::user()->id)
        ->where('team_id','<>',null)->count();
        if($tmp){
            return response()->json(['message'=>'失败，已经加入别的队伍!','res'=>'fail']);
        }

        $user = User::find($team->captain);
        $user->messages(new TeamApplyReplied($team->id, Auth::user()->id));
        $user->save();
        return response()->json(['message' => '申请成功','res'=>'success']);
    }

    public function dealApply(Team $team, Request $request)
    {   
        if ($request->res == true) {
            $user = $request->user;
            $tmp=\DB::table('contest_user')->where('contest_id', $team->contest_id)->where('user_id', $user)
            ->where('team_id','<>',null)->count();
            if($tmp){
                return response()->json(['message'=>'失败，已经加入别的队伍','res'=>'fail']);
            }

            \DB::table('contest_user')->where('contest_id', $team->contest_id)->where('user_id', $user)
                ->update(['team_id' => $team->id]);
            \DB::table('team_apply')->where('team_id', $team->id)->where('user_id', $user)
                ->update(['be_deal' => true, 'deal_time' => now()]);
            
            return response()->json(['message'=>'成功!','res'=>'success']);

        } else {
            $user = $request->user;
            \DB::table('contest_user')->where('contest_id', $team->contest_id)->where('user_id', $user)
                ->update(['team_id' => $team->id]);
            \DB::table('team_apply')->where('team_id', $team->id)->where('user_id', $user)->delete();
        }
    }

    public function getApplyList(Team $team)
    {
        $apply_user_list = \DB::table('team_apply')
            ->where('team_id', $team->id)
            ->where('be_deal', false)
            ->pluck('user_id')
            ->toArray();
        $result_user_list = array();
        foreach ($apply_user_list as $user) {
            array_push($result_user_list, User::find($user));
        }
        return $result_user_list;
    }
}

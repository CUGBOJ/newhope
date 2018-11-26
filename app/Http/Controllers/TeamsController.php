<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use http\Env\Response;
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
            'contest_id' =>'required'
        ]);


        $team = Team::create([
            'teamname' => $request->teamname,
            'captain' => Auth::user()->id,
            'contest_id'=>$request->contest_id,
        ]);
        

        $team->users()->attach(Auth::user()->id);

        return response()->json($team);
    }

    public function addMember(Team $team,$user)
    {
        if (Auth::user()->id != $team->captain) {
            abort(403);
        }

        $user_id = $user;
        \DB::table('contest_user')->where('contest_id', $team->contest_id)->where('user_id', $user_id)
            ->update(['team_id' => $team->id]);
        $team->users()->attach($user_id);//
        return;
    }

    public function removeMember(Team $team, Request $request)
    {
        //Quit Team
        if ($request->user_id == Auth::user()->id) {

            //captain
            if ($request->user_id == $team->captain) {
                DB::table('users')->where('team_id', $team->id)->update(['team_id' => null]);
                destroy();
                return response()->json('success');
            }

            //other
            \DB::table('contest_user')->where('contest_id', $team->contest_id)->where('user_id', $request->user_id)
                ->where('team_id', $team->id)->update(['team_id' => null]);
            return response()->json('success');
        }

        if (Auth::user()->id != $team->captain) {   //captain sub member
            abort(403);
        }

        \DB::table('contest_user')->where('contest_id' . $team->contest_id)->where('user_id', $request->user_id)
            ->where('team_id', $team->id)->update(['team_id' => null]);
        
        $team->users()->detach($request->id);
    }

    public function show(Team $team)
    {
        return response()->json(['base' => $team, 'grade' => $this->getGrade($team)]);
    }

    public function showTeamBasedOnContest(Contest $contest) {
        return Auth::user()->teams()->where('contest_id', '=', $contest->id)->get()->first();
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
        return response()->json('Team is destroyed!', 200);
    }

    public function apply(Team $team, Request $request)
    {
        $tmp = \DB::table('contest_user')->where('contest_id', $team->contest_id)->where('user_id', Auth::user()->id)
            ->where('team_id', '<>', null)->count();
        if ($tmp) {
            return response()->json(['message' => '失败，已经加入别的队伍!', 'res' => 'fail']);
        }

        $user = User::find($team->captain);
        $user->messages(new TeamApplyReplied($team->id, Auth::user()->id));
        $user->save();
        return response()->json(['message' => '申请成功', 'res' => 'success']);
    }

    public function dealApply(Team $team, Request $request)
    {
        if ($request->res == true) {
            $user = $request->user;
            $teamCount = \DB::table('contest_user')->where('contest_id', $team->contest_id)->where('user_id', $user)
                ->where('team_id', '<>', null)->count();
            if ($teamCount) {
                return response()->json(['message' => '失败，已经加入别的队伍', 'res' => 'fail']);
            }

            \DB::table('contest_user')->where('contest_id', $team->contest_id)->where('user_id', $user)
                ->update(['team_id' => $team->id]);
            \DB::table('team_apply')->where('team_id', $team->id)->where('user_id', $user)
                ->update(['be_deal' => true, 'deal_time' => now()]);

            return response()->json(['message' => '成功!', 'res' => 'success']);

        } else {
            $user = $request->user;
            \DB::table('contest_user')->where('contest_id', $team->contest_id)->where('user_id', $user)
                ->update(['team_id' => $team->id]);
            \DB::table('team_apply')->where('team_id', $team->id)->where('user_id', $user)->delete();
        }
    }

    public function getApplyList(Team $team)
    {
        if (Auth::user()->id != $team->captain) {
            abort(403);
        }

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

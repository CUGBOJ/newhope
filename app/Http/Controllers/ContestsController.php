<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContestRequest;
use App\Models\Contest;
use App\Models\Problem;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\RankUser;

class ContestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index'],
        ]);
    }

    public function index()
    {
        return Contest::without(['problems', 'teams'])->get();
    }

    public function show(Request $request, Contest $contest)
    {
        return response()->json($contest);
    }

    public function update(Contest $contest, ContestRequest $request)
    {
        $this->authorize('manage_contents');

        $data = [];
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['start_time'] = date("Y-m-d H:i:s", strtotime($request->start_time));
        $data['lock_board_time'] = date("Y-m-d H:i:s", strtotime($request->lock_board_time));
        $data['end_time'] = date("Y-m-d H:i:s", strtotime($request->end_time));
        $data['is_private'] = $request->is_private;
        $data['hide_other'] = $request->hide_other;

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $problems = json_decode($request->problems, true);
        $query = array_map(function ($v, $k) {
            return [
                'keychar' => $k + 1,
                'problem_id' => $v['id'],
                'color' => $v['color']
            ];
        }, $problems, array_keys($problems));

        // Play a trick here because the sync array must have index started from 1
        array_unshift($query, "");
        unset($query[0]);

        $contest->problems()->sync($query);

        $contest->update($data);

        return response()->json(['message' => 'Updated successful.'], 200);
    }

    public function store(ContestRequest $request)
    {
        $contest = Contest::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'lock_board_time' => $request->lock_board_time,
            'end_time' => $request->end_time,
            'is_private' => $request->is_private,
            'hide_other' => $request->hide_other,
            'password' => $request->password ? bcrypt($request->password) : null,
            'owner' => Auth::user()->username,
            'create_time' => now(),
        ]);

        return redirect()->route('contests.show', $contest->id);
    }

    public function add_user_by_admin(Contest $contest, User $user)
    {
        $contest->users()->attach($user->id);
        return redirect()->route('contests.show', $contest->id);
    }

    public function add_user_by_password(Contest $contest, Request $request)
    {
        $user = Auth::user();
        if (Hash::check($request->password, $contest->password)) {
            $contest->users()->attach($user->id);
        }

        return redirect()->route('contests.show', $contest->id);
    }

    public function remove_user(Contest $contest, User $user)
    {
        $contest->users()->detach($user->id);
        return response()->json(['message' => 'User removed from contest.',]);
    }

    public function add_reject_user(Contest $contest, Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if ($user == null) {
            return response()->json(['message' => 'Does not have this user.',]);
        }
        $contest->reject_users()->attach($user->id);
        return response()->json(['message' => 'User added to rejected list.',]);
    }

    public function remove_reject_user(Contest $contest, User $user)
    {
        $contest->reject_users()->detach($user->id);
        return response()->json(['message' => 'User removed from rejected list.',]);
    }

    public function getProblems(Contest $contest, Request $request)
    {
        $problem = $contest->problems();
        $perPage = request()->get('perPage') ?: 15;
        $page = request()->get('page') ?: 1;
        return $problem->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);
    }

    public function getProblem(Request $request)
    {
        $contest_id = $request->cid;
        $keychar = $request->keychar;
        $problem = \DB::table('contest_problem')->where('contest_id', $contest_id)->where('keychar', $keychar)->first();
        return $problem->problem_id;
    }

    public function getUser(Contest $contest)
    {
        $users = $contest->users();

        return $users->get();
    }

    public function getRejectUser(Contest $contest)
    {
        $reject_users = $contest->reject_users();

        return $reject_users->get();
    }

    public function getStatus(Contest $contest, Request $request)
    {
        $status = $contest->status();
        $perPage = $request->get('perPage') ?: 15;
        $page = $request->get('page') ?: 1;

        if ($request->get('search')) {
            $search = '%' . $request->get('search') . '%';
            $status = $status->orWhere('id', 'like', $search);
            $status = $status->orWhere('username', 'like', $search);
            $status = $status->orWhere('pid', 'like', $search);
        }

        if ($request->get('user')) {
            $status = $status->where('username', $request->get('username'));
        }

        if ($request->get('prob')) {
            $status = $status->where('pid', $request->get('prob'));
        }

        if ($request->get('res')) {
            $res = json_decode($request->get('res'));
            if (count($res)) {
                $status = $status->whereIn('result', $res);
            }
        }

        if ($request->get('lang')) {
            $lang = json_decode($request->get('lang'));
            if (count($lang)) {
                $status = $status->whereIn('lang', $lang);
            }
        }

        return $status->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);
    }

    public function getTopics(Contest $contest, Request $request)
    {
        $topics = $contest->topics();

        if ($request->get('search')) {
            $search = '%' . $request->get('search') . '%';
            $topics = $topics->orWhere('id', 'like', $search);
            $topics = $topics->orWhere('username', 'like', $search);
            $topics = $topics->orWhere('pid', 'like', $search);
        }

        if ($request->get('user')) {
            $topics = $topics->where('username', $request->get('username'));
        }

        if ($request->get('prob')) {
            $topics = $topics->where('pid', $request->get('prob'));
        }

        return $topics->get();
    }

    public function getStanding(Contest $contest, Request $request)
    {
        // TODO: Debug bar has an issue here to deal with the data
        \Debugbar::disable();

        $current_time = $request->time;
        if (!$current_time) {
            $current_time = now();
        }

        $user_list = array();
        $ranking_result = array();
        $status_list = Status::where('contest_id', $contest->id)->orderBy('submit_time', 'asc')->get();

        foreach ($status_list as $status) {
            if ($status->submit_time < $current_time) {
                if (!in_array($status->user->username, $user_list)) {
                    array_push($user_list, $status->user->username);
                    $ranking_result[$status->user->username] = new RankUser($status->user->id, $status->user->username);
                }
                $ranking_result[$status->user->username]->addStatus($status, $contest->start_time);
            }
        }

        usort($ranking_result, array($this, 'compareRule'));

        $rank = 1;
        foreach ($ranking_result as $user) {
            $user->rank = $rank++;
        }

        return $ranking_result;
    }

    public function compareRule($a, $b)
    {
        if (count($a->solPro) != count($b->solPro)) {
            return count($a->solPro) < count($b->solPro);
        } else {
            return $a->penalty > $b->penalty;
        }
    }

    public function destroy(Contest $contest)
    {
        $this->authorize('manage_contents');

        $contest->delete();

        return response()->json("Delete contest success.", 200);
    }
}

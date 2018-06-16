<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContestRequest;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ContestsController extends Controller
{

    public function index()
    {
        $contests = Contest::all();
        return view('contests.index', compact('contests'));
    }

    public function create()
    {
        //$this->authorize('contest_create');
        return view('contests.create');
    }

    public function show(Contest $contest)
    {
        return view('contests.show', compact('contest'));
    }

    public function edit(Contest $contest)
    {
        //$this->authorize('contest_edit');
        return view('contests.edit', compact('contest'));
    }

    public function update()
    {
        //$this->authorize('contest_edit');
    }

    public function store(ContestRequest $request)
    {
        //$this->authorize('contest_create');
        $contest = Contest::create([
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'lock_board_time' => $request->lock_board_time,
            'owner' => Auth::user()->username,
            'isprivate' => $request->is_private == 2 ? true : false,
            'hide_other' => $request->hide_other == 2 ? true : false,
            'password' => $request->is_private == 2 ? bcrypt($request->password) : null,
            'description' => $request->description,
            'create_time' => now(),
        ]);
        return redirect()->route('contests.show', $contest->id);
    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index'],
        ]);
    }

    public function add_problem(Contest $contest, Problem $problem)
    {
        $contest->users()->attach($problem->id);
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
        return redirect()->route('contests.show', $contest->id);
    }
    public function add_reject_user(Contest $contest, Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if ($user == null) {
            return response()->json(['message' => 'not have this user',
            ], 200);
        }
        $contest->reject_users()->attach($user->id);
        return redirect()->route('contests.show', $contest->id);
    }
    public function remove_reject_user(Contest $contest, User $user)
    {
        $contest->reject_users()->detach($user->id);
        return redirect()->route('contests.show', $contest->id);
    }
}

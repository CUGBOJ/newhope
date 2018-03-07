<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContestRequest;
use Illuminate\Http\Request;
use App\Models\Contest;
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
        $this->authorize('is_admin', Contest::class);
        return view('contests.create');
    }

    public function show(Contest $contest)
    {
        return view('contests.show', compact('contest'));
    }

    public function edit(Contest $contest)
    {
        $this->authorize('is_admin', Contest::class);
        return view('contests.edit', compact('contest'));
    }

    public function update()
    {
        $this->authorize('is_admin', Contest::class);
    }

    public function store(ContestRequest $request)
    {
        $this->authorize('is_admin', Contest::class);
        $contest=Contest::create([
            'title'=>$request->title,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'lock_board_time'=>$request->lock_board_time,
            'owner'=>Auth::user()->username,
            'isprivate'=>$request->is_private==2?true:false,
            'hide_other'=>$request->hide_other==2?true:false,
            'password'=>$request->is_private==2?bcrypt($request->password):null,
            'description'=>$request->description,
            'create_time'=>now(),
        ]);
        return redirect()->route('contests.show',$contest->id);
    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index']
        ]);
    }

    public function add_user(Contest $contest, Request $request)
    {

        $user = Auth::user();
        if (Hash::check($request->password, $contest->password)) {
            $contest->users()->attach($user->id);
        }
        return redirect()->route('contests.show', $contest->id);
    }
}

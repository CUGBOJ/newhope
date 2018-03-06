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
        return view('contests.create');
    }

    public function show(Contest $contest)
    {
        return view('contests.show', compact('contest'));
    }

    public function edit(Contest $contest)
    {
        return view('contests.edit', compact('contest'));
    }

    public function update()
    {

    }

    public function store(ContestRequest $request)
    {
        var_dump($request);
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContestsController extends Controller
{
    //
    public function index()
    {
        return view('contests.index', compact('contests'));
    }
    public function create()
    {
        $this->authorize('is_admin',Contest::class);
        return view('contests.create');
    }
    public function show(Contest $contest)
    {
        return view('contests.show', compact('contest'));
    }

}

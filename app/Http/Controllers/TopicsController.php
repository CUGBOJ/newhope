<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Topic;

class TopicsController extends Controller
{
    //
    public function index()
    {
        $topics = Topic::paginate(10);
        return view('topics.index', compact('topics'));
    }
    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }
}

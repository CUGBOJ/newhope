<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Topic;

class TopicsController extends Controller
{
    //
    public function index(Request $request)
    {
        $topics = Topic::paginate(10);
        $username=$request->input('username');
        $pro_id=$request->input('pro_id');
        return view('topics.index', ['username'=>$username,'pro_id'=>$pro_id]);
    }
    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }
}

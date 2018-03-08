<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Reply $reply)
    {
        $reply->content = $request->contents;
        $reply->username = Auth::user()->username;
        $reply->topic_id = $request->topic_id;
        $reply->save();
        session()->flash('success', 'Add reply success.');
        return redirect()->route('topics.show', [$reply->topic]);
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();
        session()->flash('success', 'Delete success');
        return redirect()->route('topics.show',$reply->topic);
    }
}
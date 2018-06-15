<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Reply $reply)
    {
        //$this->authorize('reply_create');
        $reply->content = $request->contents;
        $reply->username = Auth::user()->username;
        $reply->topic_id = $request->topic_id;
        $reply->save();
        session()->flash('success', 'Add reply success.');
        return redirect()->route('topics.show', [$reply->topic]);
    }

    public function destroy(Reply $reply)
    {
        if (Gate::denies('reply_destroy')) {
            if ($reply->username != Auth::user()->username) {
                abort(403);
            }
        }
        $reply->delete();
        session()->flash('success', 'Delete reply success');
        return redirect()->route('topics.show', $reply->topic);
    }
}

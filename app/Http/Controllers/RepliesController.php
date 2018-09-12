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
        $reply->content = $request->contents;
        $reply->username = Auth::user()->username;
        $reply->topic_id = $request->topic_id;
        $reply->save();

        return response()->json(['message' => 'Success.'], 200);
    }

    public function destroy(Reply $reply)
    {
        if (Gate::denies('reply_destroy')) {
            if ($reply->username != Auth::user()->username) {
                abort(403);
            }
        }

        $reply->delete();

        return response()->json(['message' => 'Delete success.'], 200);
    }
}

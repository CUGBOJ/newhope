<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Topic;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function index()
    {
        return view('topics.index');
    }

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

    public function api_topics(Request $request)
    {
        if (!$request->wantsJson()) {
            abort(404);
        }

        $topic = Topic::getModel();

        if ($request->get('search')) {
            $search = '%' . $request->get('search') . '%';
            $topic = $topic->orWhere('id', 'like', $search);
            $topic = $topic->orWhere('username', 'like', $search);
            $topic = $topic->orWhere('pid', 'like', $search);
        }

        if ($request->get('user')) {
            $topic = $topic->where('username', $request->get('username'));
        }

        if ($request->get('prob')) {
            $topic = $topic->where('pid', $request->get('prob'));
        }

        return $topic->get();
    }

    public function create()
    {
        $this->authorize('topic_create');
        return view('topics.create');
    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'index', 'api_topics']
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('topic_create');
        $this->validate($request, [
            'title' => 'required|max:50|min:2',
            'body' => 'required',
            'pid' => 'required|exists:problems,id',
        ]);

        $username = Auth::user()->username;
        $topic = Topic::create([
            'title' => $request->title,
            'body' => $request->body,
            'pid' => $request->pid,
            'username' => $username,
            'last_reply_username' => $username,
        ]);
        session()->flash('success', 'Add topic success.');
        return redirect()->route('topics.show', [$topic]);
    }

    public function destroy(Topic $topic)
    {
        if (Gate::denies('topic_destroy')) {
            if ($topic->username != Auth::user()->username) {
                abort(403);
            }
        }
        $topic->delete();
        return redirect()->route('topics.index')->with('success', 'Delete topic success.');
    }

    public function update(Topic $topic, Request $request)
    {
        if (Gate::denies('topic_edit')) {
            if ($topic->username != Auth::user()->username) {
                abort(403);
            }
        }
        $this->validate($request, [
            'title' => 'required|max:50|min:2',
            'body' => 'required',
        ]);
        $topic->update($request->all());
        session()->flash('success', 'Change topic success.');
        return redirect()->route('topics.show', [$topic]);
    }

    public function edit(Topic $topic)
    {
        if (Gate::denies('topic_edit')) {
            if ($topic->username != Auth::user()->username) {
                abort(403);
            }
        }
        return view('topics.edit', compact('topic'));
    }
}

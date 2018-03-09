<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementsController extends Controller
{
    public function index(Request $request)
    {
        $announcements = Announcement::paginate(10);
        return view('announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    public function create()
    {
        $this->authorize('announcement_create');
        return view('announcements.create');
    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'index',]
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:50|min:2',
            'body' => 'required',
        ]);
        $this->authorize('announcement_create');
        $announcement = Announcement::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);
        session()->flash('success', 'Add announcement success.');
        return redirect()->route('announcements.show', [$announcement]);
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorize('announcement_destroy');
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Delete announcement success.');
    }

    public function update(Announcement $announcement, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:50|min:2',
            'body' => 'required',
        ]);
        $this->authorize('announcement_edit');
        $announcement->update($request->all());
        session()->flash('success', 'Modify announcement success.');
        return redirect()->route('announcements.show', [$announcement]);
    }

    public function edit(Announcement $announcement)
    {
        $this->authorize('announcement_edit');
        return view('announcements.edit', compact('announcement'));
    }
}

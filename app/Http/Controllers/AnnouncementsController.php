<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index'],
        ]);
    }

    public function index(Request $request)
    {
        if (!$request->wantsJson()) {
            abort(404);
        }

        $announce = Announcement::getModel();

        if ($request->get('search')) {
            $search = '%' . $request->get('search') . '%';
            $announce = $announce->orWhere('id', 'like', $search);
            $announce = $announce->orWhere('username', 'like', $search);
            $announce = $announce->orWhere('pid', 'like', $search);
        }

        if ($request->get('user')) {
            $announce = $announce->where('username', $request->get('username'));
        }

        return $announce->get();
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
}

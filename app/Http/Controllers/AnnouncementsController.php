<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
class AnnouncementsController extends Controller
{
    public function index(Request $request)
    {
        $announcements = Announcement::paginate(10);
        return view('announcements.index',compact('announcements'));
    }

    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    public function create()
    {
        $this->authorize('is_admin',Announcement::class);
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
        $this->authorize('is_admin',Announcement::class);
        $announcement = Announcement::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);
        $this->authorize('is_admin',Announcement::class);
        session()->flash('success', '添加announcement成功');
        return redirect()->route('announcements.show', [$announcement]);
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorize('is_admin', $announcement);
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', '成功删除！');
    }

    public function update(Announcement $announcement,Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:50|min:2',
            'body' => 'required',
        ]);
        $this->authorize('is_admin',Announcement::class);
        $announcement->update($request->all());
        session()->flash('success', '修改announcement成功');
        return redirect()->route('announcements.show', [$announcement]);
    }

    public function edit(Announcement $announcement)
    {
        $this->authorize('is_admin',Announcement::class);
        return view('announcements.edit', compact('announcement'));
    }
}

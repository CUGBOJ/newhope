<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use http\Env\Response;
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

        return $announce->orderBy('updated_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $this->authorize('manage_contents');

        $this->validate($request, [
            'title' => 'required|max:50|min:2',
            'body' => 'required',
        ]);

        Announcement::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json('The announcement created successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorize('manage_contents');
        $announcement->delete();
        return response()->json('The announcement deleted successfully.');
    }

    public function update(Announcement $announcement, Request $request)
    {
        $this->authorize('manage_contents');
        $this->validate($request, [
            'title' => 'required|max:50|min:2',
            'body' => 'required',
        ]);

        $announcement->update($request->all());
        return response()->json('Modify announcement success.');
    }
}

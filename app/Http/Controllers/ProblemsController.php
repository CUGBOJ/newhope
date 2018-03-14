<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Problem;

class ProblemsController extends Controller
{
    public function create()
    {
        $this->authorize('problem_create');
        return view('problems.create');
    }

    public function show(Problem $problem)
    {
        return view('problems.show', compact('problem'));
    }

    public function show_topics(Problem $problem)
    {
        $problem_id = $problem->id;
        return view('topics.index', compact('problem_id'));
    }

    public function store(Request $request)
    {
        $this->authorize('problem_create');
        $problem = Problem::create([
            'title' => $request->title,
            'description' => $request->description,
            'input' => $request->input,
            'output' => $request->output,
            'sample_input' => $request->sample_input,
            'sample_output' => $request->sample_output,
            'special_judege' =>$request->specail_judege,
            'hint' => $request->hint,
            'hide' => $request->hide,
            'author' => $request->author,
        ]);
        session()->flash('success', 'Problem add success.');
        return redirect()->route('problems.show', [$problem]);
    }

    public function index()
    {
        return view('problems.index', compact('problems'));
    }

    public function get_problems()
    {
        $perPage = request()->get('perPage') ?: 15;
        $page = request()->get('page') ?: 1;

        return Problem::getModel()->paginate($perPage,
            ['id', 'title', 'author', 'total_submit'],
            '', $page);
    }

    public function edit(Problem $problem)
    {
        $this->authorize('problem_edit');
        return view('problems.edit', compact('problem'));
    }

    public function update(Problem $problem, Request $request)
    {
        $this->authorize('problem_edit');
        $data = [];
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['input'] = $request->input;
        $data['output'] = $request->output;
        $data['sample_input'] = $request->sample_input;
        $data['sample_output'] = $request->sample_output;
        $data['hint'] = $request->hint;

        $problem->update($data);

        session()->flash('success', 'Problem update success.');

        return redirect()->route('problems.show', $problem->id);
    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'index', 'get_problems', 'show_topics']
        ]);
    }
}

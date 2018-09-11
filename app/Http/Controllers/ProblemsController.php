<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use Illuminate\Http\Request;

class ProblemsController extends Controller
{
    public function create()
    {
        //$this->authorize('problem_create');
        return view('problems.create');
    }

    public function show(Request $request, Problem $problem)
    {
        if ($request->wantsJson()) {
            return response()->json($problem);
        } else {
            return view('problems.show', compact('problem'));
        }
    }

    public function show_topics(Problem $problem)
    {
        $pid = $problem->id;
        return view('topics.index', compact('pid'));
    }

    public function store(Request $request)
    {
        //$this->authorize('problem_create');
        $problem = Problem::create([
            'title' => $request->title,
            'description' => $request->description,
            'input' => $request->input,
            'output' => $request->output,
            'sample_input' => $request->sample_input,
            'sample_output' => $request->sample_output,
            'special_judge' => $request->specail_judge,
            'time_limit' => $request->time_limit,
            'case_time_limit' => $request->case_time_limit,
            'memory_limit' => $request->memory_limit,
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

    public function get_problems(Request $request)
    {
        $problem = Problem::getModel();
        if ($request->get('search')) {
            $search = '%' . $request->get('search'). '%';
            $problem = $problem->orWhere('id', 'like', $search);
            $problem = $problem->orWhere('title', 'like', $search);
            $problem = $problem->orWhere('author', 'like', $search);
            $problem = $problem->get(['id', 'title', 'author']);
        } else {
            $perPage = request()->get('perPage') ?: 15;
            $page = request()->get('page') ?: 1;
            $problem = $problem->paginate($perPage,
                ['id', 'title', 'author', 'total_submit_user', 'total_ac_user'],
                '', $page);
        }
        return response()->json($problem);
    }

    public function edit(Problem $problem)
    {
        //$this->authorize('problem_edit');
        return view('problems.edit', compact('problem'));
    }

    public function update(Problem $problem, Request $request)
    {
        //$this->authorize('problem_edit');
        $data = [];
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['input'] = $request->input;
        $data['output'] = $request->output;
        $data['sample_input'] = $request->sample_input;
        $data['sample_output'] = $request->sample_output;
        $data['special_judge'] = $request->special_judge;
        $data['time_limit'] = $request->time_limit;
        $data['case_time_limit'] = $request->case_time_limit;
        $data['memory_limit'] = $request->memory_limit;
        $data['hint'] = $request->hint;
        $data['hide'] = $request->hide;
        $data['author'] = $request->author;
        $problem->update($data);

        session()->flash('success', 'Problem update success.');

        return redirect()->route('problems.show', $problem->id);
    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'index', 'get_problems', 'show_topics'],
        ]);
    }
}

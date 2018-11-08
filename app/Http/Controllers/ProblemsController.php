<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use Illuminate\Http\Request;

class ProblemsController extends Controller
{

    public function show(Problem $problem)
    {
            return response()->json($problem);
    }

    public function destroy(Problem $problem)
    {
        $problem->delete();

        return response()->json('Deleted successful.', 200);
    }

    public function store(Request $request)
    {
        $prob = Problem::create([
            'title' => $request->title,
            'description' => $request->description,
            'input' => $request->input,
            'output' => $request->output,
            'sample_input' => $request->sample_input,
            'sample_output' => $request->sample_output,
            'special_judge' => $request->special_judge,
            'time_limit' => $request->time_limit,
            'case_time_limit' => $request->case_time_limit,
            'memory_limit' => $request->memory_limit,
            'hint' => $request->hint,
            'hide' => $request->hide,
            'author' => $request->author,
        ]);

        return response()->json(['message' => 'Added successful.', 'id' => $prob->id], 200);
    }

    // TODO: Split Search and Index
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

    public function update(Problem $problem, Request $request)
    {
        $data = [];
        $data['title'] = $request->title;
        $data['author'] = $request->author;
        $data['description'] = $request->description;
        $data['input'] = $request->input;
        $data['output'] = $request->output;
        $data['sample_input'] = $request->sample_input;
        $data['sample_output'] = $request->sample_output;
        $data['hint'] = $request->hint;
        $data['hide'] = $request->hide;
        $data['special_judge'] = $request->special_judge;
        $data['time_limit'] = $request->time_limit;
        $data['case_time_limit'] = $request->case_time_limit;
        $data['memory_limit'] = $request->memory_limit;
        $data['v_name'] = $request->v_name;
        $data['source'] = $request->source;
        $problem->update($data);

        return response()->json(['message' => 'Updated successful.'], 200);
    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'get_problems', 'show_topics'],
        ]);
    }
}

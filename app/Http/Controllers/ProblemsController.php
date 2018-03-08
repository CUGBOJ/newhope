<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Problem;

class ProblemsController extends Controller
{
    public function create()
    {
        $this->authorize('is_admin',Problem::class);
        return view('problems.create');
    }

    public function show(Problem $problem)
    {
        return view('problems.show', compact('problem'));
    }

    public function store(Request $request)
    {
        $this->authorize('is_admin',Problem::class);
        $problem = Problem::create([
            'title' => $request->Title,
            'description' => $request->Description,
            'input' =>  $request->Input,
            'output' => $request->Output,
            'sample_input' => $request->Sample_input,
            'sample_output' =>  $request->Sample_output,
            'hint' =>  $request->Hint,
            'author' => $request->Author,
            'ac_number'=>0,
            'submit_number'=>0,
            'ac_user_number'=>0,
            'submit_user_number'=>0,
        ]);
        session()->flash('success', 'Problem add success.');
        return redirect()->route('problems.show', [$problem]);
    }

    public function index()
    {
        return view('problems.index', compact('problems'));
    }

    public function getProblems()
    {
        $perPage = request()->get('perPage') ?: 15;
        $page = request()->get('page') ?: 1;

        return Problem::getModel()->paginate($perPage,
                ['id', 'Title', 'Author', 'Submit_number'],
                '', $page);
    }

    public function edit(Problem $problem)
    {
        $this->authorize('is_admin',$problem);
        return view('problems.edit', compact('problem'));
    }

    public function update(Problem $problem, Request $request)
    {
        $this->authorize('is_admin',$problem);
        $data = [];
        $data['Title'] = $request->Title;
        $data['Description'] = $request->Description;
        $data['Input'] = $request->Input;
        $data['Output'] = $request->Output;
        $data['Sample_input'] = $request->Sample_input;
        $data['Sample_output'] = $request->Sample_output;
        $data['Hint'] = $request->Hint;

        $problem->update($data);

        session()->flash('success', 'Problem update success.');

        return redirect()->route('problems.show', $problem->id);
   }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Problem;

class ProblemsController extends Controller
{
    public function create()
    {
        //$this->authorize('create');
        return view('problems.create');
    }
    public function show(Problem $problem)
    {
        return view('problems.show', compact('problem'));
    }

    public function store(Request $request)
    {
//        $this->validate($request, [
//            'name' => 'required|max:50',
//            'email' => 'required|email|unique:users|max:255',
//            'password' => 'required|confirmed|min:6'
//        ]);
        $this->authorize('update');
        $problem = Problem::create([
            'Title' => $request->Title,
            'Description' => $request->Description,
            'Input' =>  $request->Input,
            'Output' => $request->Output,
            'Sample_input' => $request->Sample_input,
            'Sample_output' =>  $request->Sample_output,
            'Hint' =>  $request->Hint,
            'Author' => $request->Author,
            'AC_number'=>0,
            'Submit_number'=>0,
            'AC_user_number'=>0,
            'Submit_user_number'=>0,
        ]);
        session()->flash('success', '添加成功');
        return redirect()->route('problems.show', [$problem]);
    }
    public function index()
    {
        $problems = Problem::paginate(20);
        return view('problems.index', compact('problems'));
    }

    public function edit(Problem $problem)
    {  $this->authorize('update');
        return view('problems.edit', compact('problem'));
    }
    public function update(Problem $problem, Request $request)
    {
//        $this->validate($request, [
//            'name' => 'required|max:50',
//            'password' => 'nullable|confirmed|min:6'
//        ]);
        $this->authorize('update');
        $data = [];
        $data['Title'] = $request->Title;
        $data['Description'] = $request->Description;
        $data['Input'] = $request->Input;
        $data['Output'] = $request->Output;
        $data['Sample_input'] = $request->Sample_input;
        $data['Sample_output'] = $request->Sample_output;
        $data['Hint'] = $request->Hint;

        $problem->update($data);

        session()->flash('success', '题目更新成功！');

        return redirect()->route('problems.show', $problem->id);
   }
//    public function destroy(Problem $problem)
//    {   $this->authorize('is_admin');
//        $problem->delete();
//        session()->flash('success', '成功删除题目！');
//        return back();
//    }
    public function __construct()
    {
        $this->middleware('auth');
    }
}

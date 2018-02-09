<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Problem;

class ProblemsController extends Controller
{
    public function show(Problem $problem)
    {
        return view('problems.show', compact('problem'));
    }
    public function index()
    {
        $problems = Problem::paginate(20);
        return view('problems.index', compact('problems'));
    }

//    public function edit(User $user)
//    {   $this->authorize('update', $user);
//        return view('users.edit', compact('user'));
//    }
//    public function update(User $user, Request $request)
//    {
//        $this->validate($request, [
//            'name' => 'required|max:50',
//            'password' => 'nullable|confirmed|min:6'
//        ]);
//        $this->authorize('update', $user);
//        $data = [];
//        $data['name'] = $request->name;
//        if ($request->password) {
//            $data['password'] = bcrypt($request->password);
//        }
//        $user->update($data);
//
//        session()->flash('success', '个人资料更新成功！');
//
//        return redirect()->route('users.show', $user->id);
//    }
}

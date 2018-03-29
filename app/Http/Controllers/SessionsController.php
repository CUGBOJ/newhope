<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'username' => 'required|max:255',
            'password' => 'required',
        ]);

        if ($request->expectsJson()) {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $user->last_login_ip = $request->ip();
                $user->save();
                return response()->json(['message' => "Login success."], 200);
            } else {
                return response()->json(['message' => "Login fail."], 401);
            }

        } else {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $user->last_login_ip = $request->ip();
                $user->save();
                session()->flash('success', 'Login success.');
                return redirect()->intended(route('users.show', [Auth::user()]));
            } else {
                session()->flash('danger', 'The passwords you typed do not match. Retype the trust password');
                return redirect()->back();
            }
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flush();
        return response()->json('Logout success');
    }

    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create'],
        ]);
    }
}

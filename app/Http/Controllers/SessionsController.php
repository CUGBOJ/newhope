<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class SessionsController extends Controller
{

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
            abort(404);
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->forget('password_hash');
        return response()->json('Logout success');
    }

    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create'],
        ]);
    }
}

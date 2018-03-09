<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:50|unique:users',
            'nickname' => 'required|max:50',
            'school' => 'max:20',
            'email' => 'email|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'username' => $request->username,
            'nickname' => $request->nickname,
            'school' => $request->school,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'last_login_ip' => $request->ip()
        ]);
        Auth::login($user);
        session()->flash('success', 'Register success.');
        return redirect()->route('users.show', [$user]);
    }

    public function edit(User $user)
    {
        if (Auth::user()->id != $user->id) {
            abort(403);
        }
        return view('users.edit', compact('user'));
    }

    public function update(User $user, UserRequest $request, ImageUploadHandler $uploader)
    {
        if (Auth::user()->id != $user->id) {
            abort(403);
        }
        $data = [];
        $data['nickname'] = $request->nickname;
        $data['school'] = $request->school;
        $data['email'] = $request->email;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->username);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        Auth::login($user);
        session()->flash('success', 'Update user profile success.');

        return redirect()->route('users.show', $user->username);
    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        $this->authorize('user_destroy');
        if ($user->id == Auth::user()->id) {
            abort(403);
        }
        $user->delete();
        session()->flash('success', 'Delete user success.');
        return back();
    }
}
<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['store', 'index', 'profile'],
        ]);
    }

    public function index()
    {
        $users = User::paginate(20);

        return response()->json($users);
    }

    public function profile(Request $request, string $username = '')
    {
        if ($request->wantsJson()) {
            $user = Auth::User();

            if (!empty($username)) {
                $user = User::where('username', $username)->get()->first();
            }

            if (!$user) {
                abort(404);
            }

            $user->topics;
            return response()->json($user);
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:50|unique:users',
            'nickname' => 'required|max:50',
            'school' => 'max:20',
            'email' => 'email|max:255',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'username' => $request->username,
            'nickname' => $request->nickname,
            'school' => $request->school,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'last_login_ip' => $request->ip(),
        ]);

        Auth::login($user);

        return response()->json('Register success.');
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

        return response()->json('Update user profile success.');
    }

    public function destroy(User $user)
    {
        $this->authorize('user_destroy');
        if ($user->id == Auth::user()->id) {
            abort(403);
        }
        $user->delete();

        return response()->json("Delete user success.");
    }
}

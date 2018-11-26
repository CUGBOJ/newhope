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
        $users = User::orderBy('solved', 'desc')->orderBy('submit', 'ASC')->paginate(20);

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

            $user->append('can');

            $user->topics;
            return response()->json($user);
        } else {
            abort(404);
        }
    }

    public function store(UserRequest $request)
    {
        $this->validate($request, ['username' => 'required|max:50|unique:users',]);

        $user = User::create([
            'username' => $request->username,
            'nickname' => $request->nickname,
            'school' => $request->school,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'last_login_ip' => $request->ip(),
            'avatar' => $this->regenerate_avatar($request->nickname),
        ]);

        Auth::login($user);

        return response()->json(['message' => 'Register success.'], 200);
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
            $data['avatar'] = $request->avatar;
        }

        if ($request->regenerate_avatar == 'true') {
            $data['avatar'] = $this->regenerate_avatar($request->nickname);
        }

        if ($request->register) {
            $this->validate($request, [
                'old_oj_account' => 'required|max:50|min:1',
                'student_id' => 'required|regex:/^\d{10}$/',
                'gender' => 'required|in:Male,Female,Secret',
                'major' => 'required|min:1',
                'info' => 'required|min:30',
            ]);

            $data['old_oj_account'] = $request->old_oj_account;
            $data['student_id'] = $request->student_id;
            $data['gender'] = $request->gender;
            $data['major'] = $request->major;
            $data['info'] = $request->info;
            $data['registered'] = true;
        }

        $user->update($data);
        Auth::login($user);

        return response()->json('Update user profile success.');
    }

    public function destroy(User $user)
    {
        if ($user->id == Auth::user()->id) {
            abort(403);
        }

        $user->delete();

        return response()->json("Delete user success.");
    }

    function regenerate_avatar(string $nickname)
    {
        $avatar_path = '/uploads/images/avatars/' . uniqid() . '.png';
        \Avatar::create($nickname)->setShape('square')->setDimension(200, 200)->setFontSize(99)
            ->save(public_path() . $avatar_path);
        return $avatar_path;
    }
}

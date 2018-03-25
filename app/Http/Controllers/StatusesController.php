<?php

namespace App\Http\Controllers;

use App\Handlers\PostCodeToCugbOj;
use App\Models\Status;
use Auth;
use Illuminate\Http\Request;

class StatusesController extends Controller
{
    public function index()
    {
        return view('statuses.index');
    }

    public function show(Request $request)
    {
        $perPage = $request->get('perPage') ?: 15;
        $page = $request->get('page') ?: 1;

        $status = Status::getModel();

        if ($request->get('search')) {
            $search = '%' . $request->get('search') . '%';
            $status = $status->orWhere('id', 'like', $search);
            $status = $status->orWhere('username', 'like', $search);
            $status = $status->orWhere('pid', 'like', $search);
        }

        if ($request->get('user')) {
            $status = $status->where('username', $request->get('username'));
        }

        if ($request->get('prob')) {
            $status = $status->where('pid', $request->get('prob'));
        }

        if ($request->get('res')) {
            $res = json_decode($request->get('res'));
            if (count($res)) {
                $status = $status->whereIn('result', $res);
            }
        }

        if ($request->get('lang')) {
            $lang = json_decode($request->get('lang'));
            if (count($lang)) {
                $status = $status->whereIn('lang', $lang);
            }
        }

        return $status->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);
    }

    public function store(Request $request, PostCodeToCugbOj $post)
    {

        $lang_change = array(
            0, 2, 1, 3, 6, 5, 16, 0, 9, 7,
        );
        $lang = $lang_change[$request->lang];
        if ($lang == 0) {
            return response()->json(['message' => 'fail submit'], 200);
        }
        $data = array(
            'user_id' => 'virtual_judger',
            'problem_id' => $request->pid + 999,
            'language' => $lang,
            'isshare' => 0,
            'source' => $request->code,
            'login' => 'Submit',
        );
        $url = "http://acm.cugb.edu.cn/ajax/problem_submit.php";
        $res = $post->post($url, $data);

        $result_change = array(
            'Accepted' => 1,
            'Wrong Answer' => 2,
            'Presentation Error' => 3,
            'Time Limit Exceed' => 4,
            'Runtime Error' => 5,
            'Memory Limit Exceed' => 6,
            'Output limit' => 7,
            'Judge Error' => 8,
            'Compile Error' => 9,
            'Restricted Function' => 10,
        );
        $result = json_decode(substr($res, 3))->info;
        $status = Status::create([
            'username' => Auth::user()->username,
            'pid' => $request->pid,
            'result' => $result_change[$result[0]],
            'lang' => $request->lang,
            'submit_time' => now(),
            'code' => $request->code,
            'length' => strlen($request->code),
            'time' => $result[1],
            'memory' => $result[2],
        ]);

        return response()->json(['message' => 'successful submit',
            'info' => $res,
            'other' => $result,
        ], 200);
    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'index'],
        ]);
    }
}

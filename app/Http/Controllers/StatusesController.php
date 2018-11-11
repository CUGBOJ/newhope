<?php

namespace App\Http\Controllers;

use App\Handlers\PostCodeToCugbOj;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Events\ContestMessageEvent;


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
        // dd($request);
        event(new ContestMessageEvent($request->cid,"diao"));
        $res = $post->post_to_cugb_oj($request);

        if ($res == "fail submit") {
            return response()->json(['message' => 'fail submit',
                'info' => $res,
            ], 200);
        }
        return response()->json(['message' => 'successful submit',
            'info' => $res,
        ], 200);

    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'index'],
        ]);
    }
}

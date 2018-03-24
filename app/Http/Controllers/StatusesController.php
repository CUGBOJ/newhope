<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Status;
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
            $search = '%'.$request->get('search').'%';
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

    public function store(Request $request)
    {
        $status = Status::create([
            'username' => Auth::user()->username,
            'pid' => $request->pid,
            'result' => 9,
            'lang' => $request->lang,
            'submit_time' => now(),
            'code' => $request->code,
            'length' => strlen($request->code),
        ]);

        return response()->json(['message' => 'successful submit'], 200);
    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show',  'index'],
        ]);
    }
}

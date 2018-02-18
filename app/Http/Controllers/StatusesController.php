<?php

namespace App\Http\Controllers;

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
            $status = $status->orWhere('Username', 'like', $search);
            $status = $status->orWhere('Problem_id', 'like', $search);
        }

        if ($request->get('user')) {
            $status = $status->where('Username', $request->get('username'));
        }

        if ($request->get('prob')) {
            $status = $status->where('Problem_id', $request->get('prob'));
        }

        if ($request->get('res')) {
            $res = json_decode($request->get('res'));
            if (count($res)) {
                $status = $status->whereIn('Result', $res);
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
}

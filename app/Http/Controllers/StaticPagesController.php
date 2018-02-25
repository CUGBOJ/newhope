<?php

namespace App\Http\Controllers;

use Auth;
use App\Handlers\CodeUploadHandler;
use Illuminate\Http\Request;
use App\Http\Requests\JudgeRequest;
class StaticPagesController extends Controller
{
    public function home()
    {
        return view('static_pages/home');
    }

    public function help()
    {
        return '帮助页';
    }

    public function about()
    {
        return '关于页';
    }

    public function submit_by_file()
    {
        return view('static_pages/submit');
    }

    public function judge(JudgeRequest $request,CodeUploadHandler $uploader)
    {
        $uploader->save($request->file('code'),  Auth::user()->username,$request->pro_id,$request->lang);
        return redirect()->route('statuses');
    }
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['home', 'help','about',]
        ]);
    }
}
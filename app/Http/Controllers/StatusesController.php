<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusesController extends Controller
{
    //
    public function index(Request $request){
        $username=$request->input('username');
        $pro_id=$request->input('pro_id');
        $res=$request->input('res');
        $lang=$request->input('lang');
        return view('statuses.index',['username'=>$username,'pro_id'=>$pro_id,'res'=>$res,'lang'=>$lang]);
    }
}

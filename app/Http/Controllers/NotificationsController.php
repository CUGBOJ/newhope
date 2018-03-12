<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Notifiable;
use Notification;
use Carbon\Carbon;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 获取登录用户的所有通知
        $notifications = \DB::table('notifications')
            ->whereIn('notifiable_id', [Auth::user()->id])
            ->where('read_at',null)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('notifications.index', compact('notifications'));
    }
    public function read_all(){
        Auth::user()->markAsRead();
        return redirect()->route('notifications.index');
    }
    public function read_one($id){
        $notification=\DB::table('notifications')->where('id',$id)->update(['read_at'=>now()]);
        Auth::user()->notification_count--;
        return redirect()->route('notifications.index');
    }
}

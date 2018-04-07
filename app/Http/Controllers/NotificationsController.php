<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
            ->where('read_at', null)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    public function read_all()
    {
        Auth::user()->markAsRead();

        return response()->json(['message' => '成功阅读所有通知']);
    }

    public function read_one($id)
    {
        $notification = \DB::table('notifications')
            ->where('id', $id)
            ->update(['read_at' => now()]);
        Auth::user()->notification_count--;

        return response()->json(['message' => '成功阅读一条通知']);
    }
}

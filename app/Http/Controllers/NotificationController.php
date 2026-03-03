<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = \App\Models\Notification::where('user_id', \Auth::guard('member')->id())
            ->latest()
            ->paginate(10);
            
        return view('user.notifications.index', compact('notifications'), ['title' => 'Notifications | IBSEA Member Hub']);
    }

    public function markAsRead($id)
    {
        $notification = \App\Models\Notification::where('user_id', \Auth::guard('member')->id())
            ->findOrFail($id);
            
        $notification->update(['is_read' => true]);
        
        return back()->with('success', 'Intelligence acknowledged.');
    }
    public function markAllAsRead()
    {
        \App\Models\Notification::where('user_id', \Auth::guard('member')->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return back()->with('success', 'All institutional intelligence acknowledged.');
    }
}

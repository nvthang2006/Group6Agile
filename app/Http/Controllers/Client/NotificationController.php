<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);
            
        return view('client.notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        abort_if($notification->user_id !== auth()->id(), 403);

        $notification->markAsRead();
        
        if ($notification->link) {
            return redirect($notification->link);
        }
        
        return back();
    }
}

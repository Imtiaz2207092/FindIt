<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifications = Notification::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification): void
    {
        if ($notification->user_id === auth()->user()->id) {
            $notification->update(['status' => 'Read']);
        }
    }

    public function markAllAsRead(): void
    {
        Notification::where('user_id', auth()->user()->id)
            ->update(['status' => 'Read']);
    }
}

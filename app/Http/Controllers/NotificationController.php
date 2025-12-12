<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(3);
        return view('notifications.car.index', compact('notifications'));
    }

    public function show($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);

        // Mark as read when viewing
        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return view('notifications.car.show', compact('notification'));
    }

    public function markAsRead($id)
    {
        if ($id === 'all') {
            Auth::user()->unreadNotifications->markAsRead();
            return redirect()->back()->with('success', 'All notifications marked as read');
        }

        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notification deleted successfully');
    }

    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:notifications,id'
        ]);

        Auth::user()->notifications()
            ->whereIn('id', $request->notification_ids)
            ->delete();

        return redirect()->back()->with('success', count($request->notification_ids) . ' notification(s) deleted successfully');
    }
}

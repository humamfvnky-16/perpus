<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        $items = auth()->user()->notifications()->latest()->paginate(20);
        return view('notifications.index', compact('items'));
    }

    public function markRead(string $id)
    {
        $n = auth()->user()->notifications()->findOrFail($id);
        $n->markAsRead();
        return back();
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('toast', 'Semua notifikasi ditandai dibaca.');
    }

    public function destroy(string $id)
    {
        auth()->user()->notifications()->findOrFail($id)->delete();
        return back();
    }
}

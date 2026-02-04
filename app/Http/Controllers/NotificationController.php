<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = auth()->user()->unreadNotifications()->where('id', $id)->first();
        
        if ($notification) {
            $notification->markAsRead();
            return response()->json([
                'success' => true,
                'unread_count' => auth()->user()->unreadNotifications->count()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notificación no encontrada'
        ], 404);
    }

    public function markAllAsRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'unread_count' => 0
        ]);
    }
}

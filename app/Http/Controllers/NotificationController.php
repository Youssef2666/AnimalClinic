<?php

namespace App\Http\Controllers;

use App\traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ResponseTrait;

    public function getUserNotifications(Request $request)
    {
        $notifications = Auth::user()->notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->data['title'] ?? null,
                'body' => $notification->data['body'] ?? null,
                'data' => $notification->data['data'] ?? null,
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at,
            ];
        });

        return $this->success($notifications);
    }

    public function getUserUnreadNotifications(Request $request)
    {
        $notifications = Auth::user()->unreadNotifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->data['title'] ?? null,
                'body' => $notification->data['body'] ?? null,
                'data' => $notification->data['data'] ?? null,
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at,
            ];
        });;

        return $this->success($notifications);
    }

    public function markNotificationAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();

            return $this->success(message: 'تم قراءة الإشعار بنجاح');
        }

        return $this->error(message: 'الإشعار غير موجود');
    }

}

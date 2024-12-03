<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\traits\ResponseTrait;
use Google\Cloud\Core\RestTrait;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ResponseTrait;

    public function getUserNotifications(Request $request)
    {
        $notifications = Auth::user()->notifications;

        return $this->success($notifications);
    }
}

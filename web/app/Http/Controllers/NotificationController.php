<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Notification;
use Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('visited_id', Auth::user()->id)
                                    ->with(['visiter:id,name'])
                                    ->get();
        return $notifications;
    }
}

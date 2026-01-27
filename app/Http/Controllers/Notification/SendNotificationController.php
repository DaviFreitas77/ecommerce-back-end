<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationsJob;
use App\Models\User;
use Illuminate\Http\Request;

class SendNotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        SendNotificationsJob::dispatch();      

    }
}
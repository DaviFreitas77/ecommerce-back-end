<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\WelcomeToSite;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::all()->each(fn(User $user)=>$user->notify(new WelcomeToSite));
  
    }
}
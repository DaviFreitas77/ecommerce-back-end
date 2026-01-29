<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNewOrderEmailToAdminJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $name,public string $numberOrder,public array $products,public string $telUser)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::where('role','admin')->get()->each(fn(User $user)=> $user->notify(new NewOrderNotification($this->name,$this->numberOrder,$this->products,$this->telUser)));
    }
}
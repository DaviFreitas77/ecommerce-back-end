<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\OrderCreatedOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendOrderCreatedEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $email,
        public string $name,
        public string $numberOrder,
        public array $products
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where('email', $this->email)->first();

        if ($user){
            $user->notify(new OrderCreatedOrderNotification($this->name, $this->numberOrder, $this->products));
        }

    }
}
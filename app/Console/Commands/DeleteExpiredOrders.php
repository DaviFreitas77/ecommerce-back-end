<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;



class DeleteExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove orders pending with more than 30 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Order::where('status', 'pending')
            ->where('created_at', '<', now()->subMinutes(30))
            ->delete();
    }
}

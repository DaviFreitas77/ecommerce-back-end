<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Dedoc\Scramble\Attributes\Group;


#[Group('Order')]
class DeleteOrdersExpired extends Controller
{
    /**
     * Delete all orders with status 'pending' older than 30 minutes.
     */
    public function __invoke()
    {
        $order = Order::where('status', 'pending')->where('created_at', '<', now()->subMinutes(30))->get();

        foreach ($order as $ord) {
            $ord->delete();
        }
    }
}
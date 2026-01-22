<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
use App\Models\Order;

class listAllOrdersController extends Controller
{
    /**
     * List all orders.
     */

    public function __construct(private OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function __invoke()
    {
        $allOrder = Order::with(['user', 'cupom'])->get();

        $result = $allOrder->map(function ($order) {
            return [
                'id' => $order->id,
                'number_order' => $order->number_order,
                'payment_method' => $order->payment_method,
                'status' => $order->status,
                'total' => $order->total,
                'created_at' => $order->created_at,
                'user' => $order->user->name,
                'cupom' => $order->cupom->nameCupom ?? null,

            ];
        });

        return response()->json($result);
    }
}
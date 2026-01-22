<?php

namespace App\Http\Controllers\Metrics;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
use Illuminate\Http\Request;

class MetricOrdersController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function __invoke()
    {
        $orders = $this->orderService->fetchAllOrders();
        $collection = collect($orders);

        $ordersPreparando = $collection->filter(function ($value) {
            return $value->status == 'preparando';
        });

        $ordersCompleted = $collection->filter(function ($value) {
            return $value->status == 'completed';
        });

        $ordersCanceled = $collection->filter(function ($value) {
            return $value->status == 'canceled';
        });


        $methodCreditCard = $collection->filter(function ($value) {
            return $value->payment_method == 'credit_card';
        });

        $methodPix = $collection->filter(function ($value) {
            return $value->payment_method == 'bankTransfer';
        });

        $methodBoleto = $collection->filter(function ($value) {
            return $value->payment_method == 'ticket';
        });



        return response()->json([
            'ordersCompleted' => $ordersCompleted->count(),
            'ordersPreparando' => $ordersPreparando->count(),
            'totalOrders' => $collection->count(),
            'ordersCanceled' => $ordersCanceled->count(),
            'creditCard' => $methodCreditCard->count(),
            'pix' => $methodPix->count(),
            'boleto' => $methodBoleto->count(),
        ]);
    }
}
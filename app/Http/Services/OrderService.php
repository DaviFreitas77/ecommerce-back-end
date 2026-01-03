<?php

namespace App\Http\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class OrderService
{

    public function create(int $idUser, string $status = 'pending', float $total = 0,?int $idAdress = null)
    {
        $newOder = new Order;
        $newOder->number_order = rand(10000, 99999);
        $newOder->fk_user = $idUser;
        $newOder->status = $status;
        $newOder->payment_method = null;
        $newOder->total = $total;
        $newOder->fk_adress = $idAdress;
        $newOder->created_at = now();
        $newOder->save();
        return $newOder;
    }

    public function changeOrderStatus($status,$idOrder)
    {
        $order = Order::find($idOrder);
        $order->status = $status;
        $order->save();
        return $order;
    }


    public function updatePaymentOrderService($method, $idOrder)
    {
        $idUser = Auth::user()->id;
        $order = Order::where('fk_user', $idUser)->where('id', $idOrder)->first();
        if ($order->payment_method == null) {
            $order->payment_method = $method;

            $order->save();
        }
        return $order;
    }

    

    public function fetchLatestOrder()
    {
        $idUser = Auth::user()->id;
        $orders = Order::where('fk_user', $idUser)->latest()->first();
        return $orders;
    }

    public function orderById($orderId){
        $order = Order::find($orderId);
        return $order;
    }


}

<?php

namespace App\Http\services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OrderService
{
    public function construct() {}

    public function create(int $idUser, string $status = 'pending', float $total = 0)
    {
        $newOder = new Order;
        $newOder->number_order = rand(10000, 99999);
        $newOder->fk_user = $idUser;
        $newOder->status = $status;
        $newOder->payment_method = 'mudar';
        $newOder->total = $total;
        $newOder->save();
        return $newOder;
    }

    public function changeOrderStatus(){
        $idUser = Auth::user()->id;
        $order = Order::where('fk_user', $idUser)->where('status','pending')->first();
        $order->status = 'processing';
        $order->save();
        return $order;
    }
}

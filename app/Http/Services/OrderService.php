<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class OrderService
{

    public function create(int $idUser, string $status = 'pending', float $total = 0, ?int $idAdress = null)
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

    public function changeOrderStatus($status, $idOrder)
    {
        $order = Order::find($idOrder);
        $order->status = $status;
        $order->save();
        return $order;
    }


    public function updatePaymentOrderService($method, $idOrder,$userId)
    {
   
        $order = Order::where('fk_user', $userId)->where('id', $idOrder)->first();
        if ($order->payment_method == null) {
            $order->payment_method = $method;

            $order->save();
        }
        return $order;
    }



    public function fetchLatestOrder(User $user)
    {
        $idUser = $user['id'];
        $orders = Order::where('fk_user', $idUser)->latest()->first();
        return $orders;
    }

    public function fetchOrderUser($idUser)
    {
        
        $orderUser =  Order::where('fk_user', $idUser)->get();

        $orderComplet = [];
        foreach ($orderUser as $order) {
            $orderItems = OrderItems::with('product.images', 'color', 'size')
                ->where('fk_order', $order->id)
                ->get();


            $infoproducts = $orderItems->map(function ($item) {
                return ['nameProduct' => $item->product->name, 'quantityProduct' => $item->quantity, 'imageProduct' => $item->product->images->first()->image, 'colorProduct' => $item->color->name, 'sizeProduct' => $item->size->name];
            });

            $orderComplet[] = [
                'numberOrder'    => $order->number_order,
                'status'         => $order->status,
                'total'          => $order->total,
                'payment_method' => $order->payment_method,
                'created_at'     => $order->created_at,
                'items'          => $infoproducts
            ];
        }

          return response()->json($orderComplet);
    }

    public function orderById($orderId)
    {
        $order = Order::find($orderId);
        return $order;
    }

    public function deleteOrderExpired()
    {
        $order = Order::where('status', 'pending')->where('created_at', '<', now()->subMinutes(30))->get();

        foreach ($order as $ord) {
            $ord->delete();
        }
    }

    public function fetchAllOrders()
    {
        $orders = Order::all();
        return $orders;
    }

    
}
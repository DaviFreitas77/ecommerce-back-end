<?php

namespace App\Http\Controllers;

use App\Http\Services\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class orderController extends Controller
{
    public function __construct(private OrderService $orderService) {
    }

   public function changeOrderStatus($status){
        $changeStatus = $this->orderService->changeOrderStatus($status);
        return response()->json($changeStatus);
   }

   
   public function changePaymentMethod ($method,$idOrder){
     $changePayment = $this->orderService->updatePaymentOrderService($method,$idOrder);
     return response()->json($changePayment);
   }

   public function latestOrder(){
    $latestOrder = $this->orderService->fetchLatestOrder();
    return response()->json($latestOrder);

}
}
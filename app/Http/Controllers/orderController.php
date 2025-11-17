<?php

namespace App\Http\Controllers;

use App\Http\services\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class orderController extends Controller
{
    public function __construct(private OrderService $orderService) {
    }

   public function changeOrderStatus(Request $request){
        $changeStatus = $this->orderService->changeOrderStatus();
        return response()->json($changeStatus);
   }
}

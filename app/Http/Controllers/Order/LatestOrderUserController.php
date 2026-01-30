<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;


#[Group('Order')]
class LatestOrderUserController extends Controller
{
    /**
     * informations of the latest order of the authenticated user.
     */

    public function __construct(private OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function __invoke(Request $request)
    {

         $user = $request->user();
        $latestOrder = $this->orderService->fetchLatestOrder($user);
        return response()->json($latestOrder);
    }
}
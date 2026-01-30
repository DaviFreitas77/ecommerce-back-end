<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('Order')]
class ListOrderUserController extends Controller
{

    /**
     * List order of authenticated user.
     */

    public function __construct(private  OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function __invoke(Request $request)
    {
        $user = $request->user()->id;
        return $this->orderService->fetchOrderUser($user);
    }
}
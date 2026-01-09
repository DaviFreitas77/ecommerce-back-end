<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
use Dedoc\Scramble\Attributes\Group;



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
    public function __invoke()
    {
        return $this->orderService->fetchOrderUser();
    }
}
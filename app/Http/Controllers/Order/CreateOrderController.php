<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Services\MCPService;
use App\Http\Services\OrderItemsService;
use App\Http\Services\OrderService;
use App\Http\Services\ProductService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


#[Group('Order')]
class CreateOrderController extends Controller
{

    /**
     * Create new order
     */
    public function __construct(private ProductService $productService, private OrderService $orderService, private OrderItemsService $orderItemsService, private MCPService $mcpService)
    {
        $this->productService = $productService;
        $this->orderService = $orderService;
        $this->orderItemsService = $orderItemsService;
        $this->mcpService = $mcpService;
    }

    public function __invoke(StoreOrderRequest $request)
    {
        $data = $request->validated();

        $adressId = $data['idLogradouro'] ?? null;

        if (empty($adressId) || !is_numeric($adressId)) {
            $adressId = null;
        }
        $userId = $request->user()->id;

        //cria um novo pedido
        $sumPrice = $this->productService->fethPricesProduct($data['items']);
        $newOder = $this->orderService->create($userId, 'pending', $sumPrice, $adressId);


        $newOrderItems = $this->orderItemsService->create($data['items'], $newOder->id);

        $preference = $this->mcpService->createPreferenceService($data['items'], $sumPrice, $newOder->id);


        return response()->json([
            "total" => $preference['total'],
            "orderId" => $preference['orderId'],
            "preference" => $preference
        ],Response::HTTP_CREATED);
    }
}
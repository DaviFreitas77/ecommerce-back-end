<?php

namespace App\Http\Controllers;

use App\Http\Services\MCPService;
use App\Http\Services\OrderItemsService;
use App\Http\Services\OrderService;
use App\Http\Services\ProductService;
use App\Mail\mailOrderCreated;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class orderController extends Controller
{
  public function __construct(private OrderService $orderService, private OrderItemsService $orderItemsService, private ProductService $productService, private MCPService $mcpService) {}


  public function crateOrder(Request $request)
  {
    $validated = $request->validate([
      'items' => ['required', 'array'],
      'idLogradouro' => ['nullable']
    ]);

    $adressId = $validated['idLogradouro'] ?? null;

    if (empty($adressId) || !is_numeric($adressId)) {
      $adressId = null;
    }
    $userId = Auth::user()->id;

    //cria um novo pedido
    $sumPrice = $this->productService->fethPricesProduct($validated['items']);
    $newOder = $this->orderService->create($userId, 'pending', $sumPrice, $adressId);


    $newOrderItems = $this->orderItemsService->create($validated['items'], $newOder->id);

    $preference = $this->mcpService->createPreferenceService($validated['items'], $sumPrice, $newOder->id);



    return response()->json([
      "total" => $preference['total'],
      "orderId" => $preference['orderId'],
      "preference" => $preference
    ]);
  }



  public function changePaymentMethod($method, $idOrder)
  {
    $changePayment = $this->orderService->updatePaymentOrderService($method, $idOrder);
    return response()->json($changePayment);
  }

  public function latestOrder()
  {
    $latestOrder = $this->orderService->fetchLatestOrder();
    return response()->json($latestOrder);
  }

  public function fetchOrderUser()
  {
    $idUser = Auth::user()->id;
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

  public function deleteOrderExpired()
  {
    $order = Order::where('status', 'pending')->where('created_at', '<', now()->subMinutes(30))->get();

    foreach ($order as $ord) {
      $ord->delete();
    }
  }
}

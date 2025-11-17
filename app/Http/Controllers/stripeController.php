<?php

namespace App\Http\Controllers;

use App\Http\services\OrderItemsService;
use App\Http\services\OrderService;
use App\Http\services\ProductService;
use App\Models\Order;
use App\Models\orderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class stripeController extends Controller
{
    public function __construct(private ProductService $productService, private OrderService $orderService, private OrderItemsService $orderItemsService) {}
    public function createPayment(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array'],
            'method' => ['required', 'string']
        ]);

        $userId = Auth::user()->id;

        $sumPrice = $this->productService->fethPricesProduct($validated['items']);

        $existingOrder = Order::where('fk_user', $userId)->where('status','pending')->first();

        if ($existingOrder) {
            $orderItems = OrderItems::where('fk_order', $existingOrder->id);

            if ($orderItems) {
                $orderItems->delete();
            }

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['id']);
                $newOrderItems = $this->orderItemsService->create($validated['items'], $userId, $existingOrder->id);
            }

            $existingOrder->total = $sumPrice;
            $existingOrder->save();
        } else {
            //cria um novo pedido
            $newOder = $this->orderService->create($userId, 'pending', $validated['method'], $sumPrice);
            $newOrderItems = $this->orderItemsService->create($validated['items'], $userId, $newOder->id);
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $sumPrice * 100,
            'currency' => 'brl',
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
}

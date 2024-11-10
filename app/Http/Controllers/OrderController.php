<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $orders = Auth::user()?->orders()->with('products.category')->get();
        return $this->success($orders);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_date' => $request->order_date,
            'status' => OrderStatus::CONFIRMED->value,
            'payment_method_id' => $request->payment_method_id
        ]);
        return $this->success($order);
    }

    public function addProductsToOrder(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $products = $request->input('products');

        foreach ($products as $productData) {
            $product = Product::find($productData['product_id']);

            if (!$product) {
                return response()->json(['error' => 'المنتج غير موجود'], 404);
            }

            $order->products()->attach($product->id, [
                'quantity' => $productData['quantity'],
                'price_at_purchase' => $product->price
            ]);
        }

        return response()->json(['message' => 'تم إضافة المنتجات إلى الطلب', 'order' => $order], 201);
    }

    public function updateOrderPaymentMethod(Request $request, $orderId){
        $order = Order::findOrFail($orderId);
        $order->payment_method_id = $request->payment_method_id;
        $order->save();
        return $this->success($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $order = Auth::user()
        ->orders()
        ->where('id', $id)
        ->with('products.category')
        ->first();

    if (!$order) {
        return $this->error('الطلب غير موجود', 404);
    }

    return $this->success($order);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

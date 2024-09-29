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
                return response()->json(['error' => 'Product not found'], 404);
            }

            $order->products()->attach($product->id, [
                'quantity' => $productData['quantity'],
                'price_at_purchase' => $product->price
            ]);
        }

        return response()->json(['message' => 'Products added to order successfully', 'order' => $order], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    // Find the authenticated user's order by ID and load products with their categories
    $order = Auth::user()
        ->orders()
        ->where('id', $id)
        ->with('products.category') // Eager load the product's category
        ->first();

    // Check if the order exists
    if (!$order) {
        return $this->error('Order not found', 404);
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

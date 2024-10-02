<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $products = Product::all()->map(function ($product) {
            if ($product->image) {
                $product->image_url = asset('storage/' . $product->image);
            } else {
                $product->image_url = null; // Set it to null if the image is null
            }
            return $product;
        });

        return $this->success($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Find the product by ID or fail
            $product = Product::findOrFail($id);

            // Add image URL to the product object
            $product->image_url = $product->image ? asset('storage/' . $product->image) : null;

            return $this->success($product);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
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

    public function putProductInFavorite(Request $request, $id)
    {
        Auth::user()->favoriteProducts()->toggle($id);
        return $this->success();
    }

    public function getMyFavoriteProducts(Request $request)
    {
        $favorites = Auth::user()->favoriteProducts()->with('category')->get();
        return $this->success($favorites);
    }

}

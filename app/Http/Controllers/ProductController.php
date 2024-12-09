<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use ResponseTrait;
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
            })
            ->when($request->product_category_id, function ($query) use ($request) {
                $query->where('product_category_id', $request->product_category_id);
            })
            ->when($request->min_price && $request->max_price, function ($query) use ($request) {
                $query->whereBetween('price', [$request->min_price, $request->max_price]);
            })
            ->when($request->min_price && !$request->max_price, function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price);
            })
            ->when(!$request->min_price && $request->max_price, function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price);
            })
            ->when($request->most_popular, function ($query) {
                $query->withCount('favouritedByUsers')->orderBy('favourited_by_users_count', 'desc');
            })
            ->with(['category'])
            ->get()
            ->map(function ($product) {
                $product->image_url = $product->image ? asset('storage/' . $product->image) : null;
                $product->is_favorited = Auth::user() && $product->favouritedByUsers->contains(Auth::id());
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
            $product = Product::findOrFail($id);

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

    public function toggleProductInFavorite(Request $request, $id)
    {
        Auth::user()->favoriteProducts()->toggle($id);
        return $this->success();
    }

    public function getMyFavoriteProducts(Request $request)
{
    $favorites = Auth::user()->favoriteProducts()
        ->with('category')
        ->get()
        ->map(function ($product) {
            $product->image_url = $product->image ? asset('storage/' . $product->image) : null;
            $product->is_favorited = true;
            return $product;
        });

    return $this->success($favorites);
}


}

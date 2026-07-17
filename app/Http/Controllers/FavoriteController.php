<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * お気に入り一覧
     */
    public function index()
    {
        $products = Auth::user()
            ->favoriteProducts()
            ->with(['user', 'category'])
            ->latest('products.created_at')
            ->get();

        return view('favorites.index', compact('products'));
    }

    /**
     * お気に入りの登録/解除 (トグル)
     */
    public function toggle(Product $product)
    {
        Auth::user()->favoriteProducts()->toggle($product->id);

        return back();
    }
}

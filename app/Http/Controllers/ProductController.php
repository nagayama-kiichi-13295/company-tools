<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * 商品一覧
     */
    public function index()
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }

    /**
     * 商品登録画面
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * 商品登録
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'max:255'],
            'description' => ['required'],
            'price'       => ['required', 'integer', 'min:0'],
        ]);

        $validated['user_id'] = Auth::id();

        Product::create($validated);

        return redirect()->route('products.index')
                         ->with('success', '商品を出品しました。');
    }

    /**
     * 商品詳細
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * 商品編集画面
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * 商品更新
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * 商品削除
     */
    public function destroy(Product $product)
    {
        //
    }
}

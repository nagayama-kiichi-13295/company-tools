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
        return view('products.show', compact('product'));
    }

    /**
     * 商品編集画面
     */
    public function edit(Product $product)
    {
        // 自分の商品以外は編集不可
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        return view('products.edit', compact('product'));
    }

    /**
     * 商品更新
     */
    public function update(Request $request, Product $product)
    {
        // 自分の商品以外は編集不可
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'        => ['required', 'max:255'],
            'description' => ['required'],
            'price'       => ['required', 'integer', 'min:0'],
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.show', $product)
            ->with('success', '商品を更新しました。');
    }

    /**
     * 商品削除
     */
    public function destroy(Product $product)
    {
        // 自分以外の商品は削除不可
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', '商品を削除しました。');
    }
}

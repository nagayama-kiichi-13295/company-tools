<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
        //
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

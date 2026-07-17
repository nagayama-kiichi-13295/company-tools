<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'image'       => ['nullable', 'image', 'max:2048'], //2048KB = 2MB
        ]);

        // 画像が送られてきたら storage/app/public/products に保存し、パスを持たせる
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($validated['image']); // ファイル本体は保存しないので除外
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
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')){
            // 古い画像があれば削除
            if ($product->image_path){
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($validated['image']);
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

    /**
     * 購入する(募集中 -> 取引中)
     */
    public function purchase(Product $product)
    {
        // 自分の商品は買えない
        if ($product->user_id === Auth::id()) {
            abort(403);
        }

        // 募集中以外は購入不可
        if ($product->status !== 'available') {
            return redirect()->route('products.show', $product)
                ->with('error', 'この商品は既に取引中または完了しております。');
        }

        $product->status   = 'trading';
        $product->buyer_id = Auth::id();
        $product->save();

        return redirect()->route('products.show', $product)
            ->with('success', '購入手続きを開始しました。');
    }

    /**
     * 取引完了にする(取引中 -> 完了)
     */
    public function complete(Product $product)
    {
        // 出品者か購入者のみ
        if ($product->user_id !== Auth::id() && $product->buyer_id !== Auth::id()){
            abort(403);
        }

        // 取引中以外は完了不可
        if ($product->status !== 'trading') {
            return redirect()->route('products.show', $product)
                ->with('error', '取引中の商品のみ完了にできます。');
        }

        $product->status = 'complete';
        $product->save();

        return redirect()->route('products.show', $product)
            ->with('success', '取引を完了しました。');
    }
}

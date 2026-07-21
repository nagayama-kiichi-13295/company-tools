<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * 商品一覧
     */
    public function index(Request $request)
    {
        $keyword    = $request->input('keyword');
        $categoryId = $request->input('category_id');

        $products   = Product::with(['user', 'category'])
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                      ->orWhere('description', 'like', "%{$keyword}%");
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->get();
        
        $favoriteIds = Auth::user()
            ->favoriteProducts()
            ->pluck('products.id')
            ->toArray();
        
        $categories = Category::orderBy('id')->get();

        return view('products.index', compact('products', 'categories', 'keyword', 'categoryId', 'favoriteIds'));
    }

    /**
     * 商品登録画面
     */
    public function create()
    {
        $categories = Category::orderBy('id')->get();
        return view('products.create', compact('categories'));
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
            'category_id' => ['nullable', 'exists:categories,id'],
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
        $isFavorite = Auth::user()
            ->favoriteProducts()
            ->where('products.id', $product->id)
            ->exists();

        return view('products.show', compact('product', 'isFavorite'));
    }

    /**
     * 商品編集画面
     */
    public function edit(Product $product)
    {
        // 自分の商品以外は編集不可
        $this->authorize('update', $product);

        $categories = Category::orderBy('id')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * 商品更新
     */
    public function update(Request $request, Product $product)
    {
        // 自分の商品以外は編集不可
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name'        => ['required', 'max:255'],
            'description' => ['required'],
            'price'       => ['required', 'integer', 'min:0'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'category_id' => ['nullable', 'exists:categories,id'],
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
        $this->authorize('delete', $product);
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
        $this->authorize('purchase', $product);

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
        $this->authorize('complete', $product);

        $product->status = 'completed';
        $product->save();

        return redirect()->route('products.show', $product)
            ->with('success', '取引を完了しました。');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * チャット画面
     */
    public function index(Product $product)
    {
        $this->authorize('chat', $product);
        $messages = $product->messages()->with('user')->oldest()->get();
        return view('messages.index', compact('product', 'messages'));
    }

    /**
     * メッセージ送信
     */
    public function store(Request $request, Product $product)
    {
        $this->authorizeChat('chat', $product);
        $validated = $request->validate([
            'body' => ['required', 'max:1000'],
        ]);

        // hasManyのcreateなら product_id は自動でセットされる
        $product->messages()->create([
            'user_id' => Auth::id(),
            'body'    => $validated['body'],
        ]);

        return redirect()->route('messages.index', $product);
    }
}
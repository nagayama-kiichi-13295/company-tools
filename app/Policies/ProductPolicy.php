<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * 編集・更新・削除できるのは出品者本人だけ
     */
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }

    /**
     * 購入できるのは「自分の商品ではない」かつ「募集中」のとき
     */
    public function purchase(User $user, Product $product): bool
    {
        return $user->id !== $product->user_id
            && $product->status === 'available';
    }

    /**
     * 取引完了にできるのは出品者か購入者で、取引中のとき
     */
    public function compete(User $user, Product $product): bool
    {
        return ($user->id === $product->user_id || $user->id === $product->buyer_id)
            && $product->status === 'trading';
    }

    /**
     * チャットできるのは出品者か購入者
     */
    public function chat(User $user, Product $product): bool
    {
        return $user->id === $product->user_id
            || $user->id === $product->buyer_id;
    }
}

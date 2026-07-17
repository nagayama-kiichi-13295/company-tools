<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'price',
        'image_path',
        'status',
        'buyer_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 購入者
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // 状態を日本語で表示する
    public function statusLabel(): string
    {
        return match ($this->status) {
            'available' => '募集中',
            'trading'   => '取引中',
            'completed' => '完了',
            default     => $this->status,
        };
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

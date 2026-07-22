<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }

    // 自分が出品した商品
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // 自分が購入した商品
    public function purchasedProducts()
    {
        return $this->hasMany(Product::class, 'buyer_id');
    }

    public function joinedEvents()
    {
        return $this->belongsToMany(Event::class);
    }

    // 送ったDM
    public function sentMessages()
    {
        return $this->hasMany(DirectMessage::class, 'sender_id');
    }

    // 受け取ったDM
    public function receivedMessages()
    {
        return $this->hasMany(DirectMessage::class, 'receiver_id');
    }

    public function groupTags()
    {
        return $this->belongsToMany(GroupTag::class);
    }
}

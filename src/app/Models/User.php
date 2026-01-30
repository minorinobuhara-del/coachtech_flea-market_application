<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Item;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'postcode',
        'address',
        'building',
        'profile_completed',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'profile_completed' => 'boolean',
    ];

    // ユーザーが出品した商品
    public function sellingItems()
    {
        return $this->hasMany(Item::class);//seller_id
    }

    //ユーザーが購入した商品
    //※ 購入履歴テーブルができてから実装
    public function purchasedItems()
    {
        //return $this->hasMany(Item::class, 'user_id');//buyer_id
        return collect();
    }

    //ユーザーのお気に入り商品
    public function favoriteItems()
    {
        return $this->belongsToMany(
            Item::class,
            'favorites',
            'user_id',
            'item_id'
        )->withTimestamps();
    }
}

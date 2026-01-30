<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;


class Item extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'brand',
        'price',
        'description',
        'image_path',
        'condition',
    ];

    //商品のカテゴリー
    public function category()
{
    return $this->belongsTo(Category::class);
}

    //商品の出品者(ユーザー)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //商品のお気に入りユーザー
    public function favoredByUsers()
    {
        return $this->belongsToMany(
            User::class,
            'favorites',
            'item_id',
            'user_id'
        );
    }

    //商品のいいねユーザー
    public function likes()
    {
    return $this->hasMany(Like::class);
    }

    public function isLikedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->likes()
            ->where('user_id', $user->id)
            ->exists();
    }

    //吹き出しコメント
    public function comments()
    {
    return $this->hasMany(Comment::class);
    }
}

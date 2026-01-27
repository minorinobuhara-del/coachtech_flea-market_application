<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Item extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'price',
        'description',
        'image_path',
        'condition',
    ];
    public function category()
{
    return $this->belongsTo(Category::class);
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

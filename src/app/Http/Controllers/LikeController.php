<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;

class LikeController extends Controller
{
    public function toggle(Item $item)
    {
        $user = auth()->user();

        // すでにいいねしているか確認
        $like = Like::where('item_id', $item->id)
                    ->where('user_id', $user->id)
                    ->first();

        if ($like) {
            // いいね解除
            $like->delete();
        } else {
            // いいね追加
            Like::create([
                'item_id' => $item->id,
                'user_id' => $user->id,
            ]);
        }

        return back();
    }
}

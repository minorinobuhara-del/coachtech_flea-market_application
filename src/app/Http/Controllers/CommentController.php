<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Item $item)
    {
        //  ログイン必須
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        // バリデーション
        $request->validate([
            'content' => ['required', 'string', 'max:255'],
        ], [
            'content.required' => 'コメントを入力してください',
            'content.max' => 'コメントは255文字以内で入力してください',
        ]);
        //　コメント作成
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'content' => $request->content,
        ]);
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    // 商品一覧（ログイン前）
    public function index(Request $request)
    {
        $items = Item::latest()->get();
        return view('items.index', compact('items'));
    }

    // 検索処理
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $items = Item::when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })->latest()->get();

        return view('items.index', compact('items', 'keyword'));
    }

    // 商品詳細（ログイン前）
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }
}

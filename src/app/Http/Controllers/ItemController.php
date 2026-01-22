<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    // 商品一覧（ログイン前）
    public function index()
    {
        $items = Item::latest()->get();

        return view('items.index', compact('items'));
    }

    // 商品詳細（ログイン前）
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }
}

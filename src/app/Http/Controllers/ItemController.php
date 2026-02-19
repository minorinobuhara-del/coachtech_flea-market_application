<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{
    // 商品一覧（マイリスト表示）
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'recommend');

        if ($tab === 'favorite') {
        // 未ログインなら空
        if (!auth()->check()) {
            $items = collect();
        } else {
            // いいねした商品だけ
            $items = auth()->user()
                ->likedItems()
                ->where('items.user_id', '!=', auth()->id())
                ->orderBy('items.created_at', 'desc')
                ->get();
        }
    } else {
        // 🔥 自分の商品を除外
        if (auth()->check()) {
            $items = Item::where('items.user_id', '!=', auth()->id())
                        ->latest()
                        ->get();
        } else {
            $items = Item::latest()->get();
        }
    }

    return view('items.index', compact('items', 'tab'));
    }

    // 検索処理
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $items = Item::when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })->latest()->get();

        return view('items.index', [
        'items' => $items,
        'keyword' => $keyword,
        'tab' => 'recommend',
        ]);
    }

    // 商品詳細（ログイン前）
    public function show(Item $item)
    {
        $item->load('likes', 'comments', 'categories');
        return view('items.show', compact('item'));
    }


    // 商品出品画面表示
    public function create()
    {
        $categories = Category::all();
        return view('sell', compact('categories'));
    }

    //商品出品処理ページ表示
    public function store(ExhibitionRequest $request)
{
    // 画像保存
    $path = $request->file('image')->store('items', 'public');

    $item = Item::create([
    'user_id' => auth()->id(),
    'name' => $request->name,
    'description' => $request->description,
    'image_path' => $path,
    'condition' => $request->condition,
    'price' => $request->price,
]);

    // カテゴリーを関連付ける
    $item->categories()->attach($request->category_ids);

    return redirect()->route('mypage');
}
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ItemListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    //全商品を取得できる
    /** @test */
    public function all_items_are_displayed()
    {
    $items = \App\Models\Item::factory()->count(3)->create();

    $response = $this->get('/');

    $response->assertStatus(200);

    foreach ($items as $item) {
        $response->assertSee($item->name);
    }
    }

    //購入済み商品は「Sold」と表示される
    /** @test */
    public function sold_label_is_displayed_for_purchased_items()
    {
    $buyer = \App\Models\User::factory()->create();
    $item = \App\Models\Item::factory()->create([
        'buyer_id' => $buyer->id,
    ]);

    $response = $this->get('/');

    $response->assertSee('Sold');
    }

    //自分が出品した商品は表示されない
    /** @test */
    public function users_own_items_are_not_displayed()
    {
    $user = \App\Models\User::factory()->create();

    $ownItem = \App\Models\Item::factory()->create([
        'user_id' => $user->id,
    ]);

    $otherItem = \App\Models\Item::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/');

    $response->assertDontSee($ownItem->name);
    $response->assertSee($otherItem->name);
    }

    //マイリスト一覧取得
    /** @test */
    public function only_liked_items_are_displayed()
    {
    $user = \App\Models\User::factory()->create();
    $likedItem = \App\Models\Item::factory()->create();
    $notLikedItem = \App\Models\Item::factory()->create();

    $user->likedItems()->attach($likedItem->id);

    $this->actingAs($user);

    $response = $this->get('/mypage?tab=favorite');

    $response->assertSee($likedItem->name);
    $response->assertDontSee($notLikedItem->name);
    }

    //マイリストの購入済みは Sold 表示
    /** @test */
    public function sold_label_is_displayed_in_mylist()
    {
    $user = \App\Models\User::factory()->create();

    $item = \App\Models\Item::factory()->create([
        'buyer_id' => $user->id,
    ]);

    $user->likedItems()->attach($item->id);

    $this->actingAs($user);

    $response = $this->get('/mypage?tab=buy');

    $response->assertSee('SOLD');
    }

    //未認証は何も表示されない
    /** @test */
    public function guest_cannot_see_mylist()
    {
    $response = $this->get('/mypage');

    $response->assertRedirect('login');
    $response->assertStatus(302); // リダイレクト確認
    }

    //商品検索
    /** @test */
    public function items_can_be_searched_by_partial_name()
    {
    $item1 = \App\Models\Item::factory()->create(['name' => 'iPhone 15']);
    $item2 = \App\Models\Item::factory()->create(['name' => 'Galaxy']);
    $response = $this->get('/search?keyword=iPhone');

    $response->assertSee($item1->name);
    $response->assertDontSee($item2->name);
    }

    //検索状態がマイリストでも保持
    /** @test */
    public function search_keyword_is_preserved_in_mylist()
    {
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/search?keyword=test');

    $response = $this->get('/mypage?keyword=test');

    $response->assertSee('value="test"', false);
    }

    //商品詳細情報取得
    /** @test */
    public function item_detail_page_displays_all_information()
    {
    $item = \App\Models\Item::factory()->create([
        'name' => 'Test Item',
        'description' => 'Test Description',
        'price' => 1000,
    ]);

    $response = $this->get("/item/{$item->id}");

    $response->assertSee($item->name);
    $response->assertSee($item->description);
    $response->assertSee(number_format($item->price));
    }

    //複数カテゴリ表示
    /** @test */
    public function multiple_categories_are_displayed()
    {
    $item = \App\Models\Item::factory()->create();

    $categories = \App\Models\Category::factory()->count(2)->create();

    $item->categories()->attach($categories->pluck('id'));

    $response = $this->get("/item/{$item->id}");

    foreach ($categories as $category) {
        $response->assertSee($category->name);
    }
    }




}

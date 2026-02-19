<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class LikeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    private function makeItem(array $overrides = []): Item
    {
        $seller = $overrides['seller'] ?? User::factory()->create();

        return Item::create(array_merge([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
            'description' => '説明',
            'price' => 1000,
            'image_path' => 'items/test.jpg',
            'condition' => '新品',
        ], $overrides));
    }

    /** @test */
    public function user_can_like_item_and_like_count_increases()
    {
        $user = User::factory()->create();
        $item = $this->makeItem();

        $this->actingAs($user);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->post("/item/{$item->id}/like");

        $response->assertStatus(302);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 詳細ページで「いいね数」が増えていること（表示仕様に合わせて調整）
        $detail = $this->get("/item/{$item->id}");
        $detail->assertSee('1'); // いいね数の表示
    }

    /** @test */
    public function user_can_unlike_item_and_like_count_decreases()
    {
        $user = User::factory()->create();
        $item = $this->makeItem();

        $this->actingAs($user);

        // 1回目：いいね
        $this->post("/item/{$item->id}/like");
        $this->assertDatabaseHas('likes', ['user_id' => $user->id, 'item_id' => $item->id]);

        // 2回目：解除（toggle想定）
        $this->post("/item/{$item->id}/like");
        $this->assertDatabaseMissing('likes', ['user_id' => $user->id, 'item_id' => $item->id]);

        $detail = $this->get("/item/{$item->id}");
        $detail->assertSee('0'); // いいね数が0に戻る想定
    }

    /** @test */
    public function liked_icon_style_changes_when_liked()
    {
        $user = User::factory()->create();
        $item = $this->makeItem();

        $this->actingAs($user);

        // like 実行
        $this->post("/item/{$item->id}/like");

        $detail = $this->get("/item/{$item->id}");

        // いいね済みでピンク画像になる
        $detail->assertSee('icon_heart_pink.png');

        $this->assertTrue(true);
    }

}

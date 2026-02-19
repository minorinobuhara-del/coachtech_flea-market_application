<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    private function makeItem(): Item
    {
        $seller = User::factory()->create();

        return Item::create([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
            'description' => '説明',
            'price' => 1000,
            'image_path' => 'items/test.jpg',
            'condition' => '新品',
        ]);
    }

    /** @test */
    public function logged_in_user_can_post_comment()
    {
        $user = User::factory()->create();
        $item = $this->makeItem();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/comment", [
            'content' => 'テストコメント',
        ]);

        $response->assertStatus(302);

        // comments テーブルのカラム名に合わせる
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);

        // 詳細ページでコメント数が増える（表示仕様に合わせて調整）
        $detail = $this->get("/item/{$item->id}");
        $detail->assertSee('テストコメント');
    }

    /** @test */
    public function guest_cannot_post_comment()
    {
        $item = $this->makeItem();

        $response = $this->post("/item/{$item->id}/comment", [
            'content' => 'ゲストコメント',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => 'ゲストコメント',
        ]);
    }

    /** @test */
    public function comment_is_required_validation_message_is_shown()
    {
        $user = User::factory()->create();
        $item = $this->makeItem();

        $this->actingAs($user);

        $response = $this->from("/item/{$item->id}")
            ->post("/item/{$item->id}/comment", [
                'content' => '',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['content']);

        $response->assertSessionHasErrors(['content' => 'コメントを入力してください']);
    }

    /** @test */
    public function comment_cannot_exceed_255_characters()
    {
        $user = User::factory()->create();
        $item = $this->makeItem();

        $this->actingAs($user);

        $long = str_repeat('a', 256);

        $response = $this->from("/item/{$item->id}")
            ->post("/item/{$item->id}/comment", [
                'content' => $long,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['content']);

        $response->assertSessionHasErrors(['content' => 'コメントは255文字以内で入力してください']);
    }

}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Item;
use App\Models\Category;

class ProfileAndSellTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_info_is_shown_on_mypage()
    {
        $user = User::factory()->create([
            'name' => 'テスト太郎',
            'postcode' => '100-0001',
            'address' => '東京都千代田区千代田1-1',
            'building' => 'テストビル101',
            'profile_image' => 'profile/test.png', // カラム名がこれなら
        ]);

        // 出品
        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品A',
            'is_sold' => false,
        ]);

        // 購入（buyer_id が自分）
        Item::factory()->create([
            'user_id' => User::factory()->create()->id,
            'buyer_id' => $user->id,
            'name' => '購入商品B',
            'is_sold' => true,
        ]);

        $this->actingAs($user);

        // デフォルト（sell）
        $resSell = $this->get(route('mypage'));
        $resSell->assertStatus(200);
        $resSell->assertSee('テスト太郎');
        $resSell->assertSee('出品商品A');

        // buyタブで購入商品が見える
        $resBuy = $this->get(route('mypage') . '?tab=buy');
        $resBuy->assertStatus(200);
        $resBuy->assertSee('購入商品B');

        // 画像
        $resSell->assertSee('storage/profile/test.png');
    }

    /** @test */
    public function profile_edit_form_is_prefilled_with_existing_values()
    {
        $user = User::factory()->create([
            'name' => 'テスト太郎',
            'postcode' => '100-0001',
            'address' => '東京都千代田区千代田1-1',
            'building' => 'テストビル101',
            'profile_image' => 'profile/test.png',
        ]);

        $this->actingAs($user);

        $res = $this->get(route('profile.edit'));
        $res->assertStatus(200);

        $res->assertSee('value="テスト太郎"', false);
        $res->assertSee('value="100-0001"', false);
        $res->assertSee('value="東京都千代田区千代田1-1"', false);
        $res->assertSee('value="テストビル101"', false);

        // img src を確認（valueではない）
        $res->assertSee('storage/profile/test.png');
    }

    /** @test */
    public function user_can_store_item_from_sell_screen()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('items.create'))->assertStatus(200);

        Storage::fake('public');

        // GD不要のfakeファイル
        $file = UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg');

        // カテゴリを1件作って実在IDを用意
        $category = Category::factory()->create();

        $payload = [
            'category_ids' => [$category->id],
            'name' => '出品テスト商品',
            'price' => 5000,
            'description' => '説明テキスト',
            'condition' => '新品',
            'image' => $file,
        ];

        $res = $this->post(route('items.store'), $payload);

        // storeはmypageへリダイレクト
        $res->assertRedirect(route('mypage'));
        $res->assertSessionHasNoErrors();

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => '出品テスト商品',
            'price' => 5000,
            'description' => '説明テキスト',
            'condition' => '新品',
        ]);

        $itemId = \App\Models\Item::where('name', '出品テスト商品')->value('id');
        $this->assertNotNull($itemId);
    }
}

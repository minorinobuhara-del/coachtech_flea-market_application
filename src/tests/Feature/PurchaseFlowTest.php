<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class PurchaseFlowTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    //支払い方法選択機能テスト
    /** @test */
    public function payment_method_selection_is_reflected_on_subtotal_screen()
    {
    $user = \App\Models\User::factory()->create();
    $item = \App\Models\Item::factory()->create();

    $this->actingAs($user);

    // 購入確定(POST)で支払い方法を送る（あなたの実装に合わせてnameを調整）
    $res = $this->post(route('purchase.store', $item), [
        'payment_method' => 'card',
    ]);

    // どこに飛ぶ仕様かで変わる（決済画面へ飛ぶなら）
    $res->assertRedirect('/mypage?tab=buy');

    // 反映確認（表示文言は実装に合わせる）
    $response = $this->get(route('purchase.show', $item));
    $response->assertSee('カード'); // 例: 画面に出ている文字に合わせる
    }

    //配送先変更機能テスト
    /** @test */
    public function shipping_address_registered_on_address_screen_is_reflected_on_purchase_screen()
    {
    $user = User::factory()->create();
    $item = Item::factory()->create();

    $this->actingAs($user);

    // 住所登録
    $this->post('/purchase/address', [
        'postal_code' => '100-0001',
        'address'     => '東京都千代田区千代田1-1',
        'building'    => 'テストビル101',
    ])->assertRedirect();

    // 購入画面を再度開く → 住所が表示されていること
    $response = $this->get("/purchase/{$item->id}");
    $response->assertStatus(200);

    $response->assertSee('100-0001');
    $response->assertSee('東京都千代田区千代田1-1');
    $response->assertSee('テストビル101');
    }

    //購入した商品に送付先住所が紐づいて登録されるテスト
    /** @test */
    public function purchased_item_is_saved_with_selected_shipping_address()
    {
    $user = User::factory()->create();
    $item = Item::factory()->create();

    $this->actingAs($user);

    // 住所登録 → addressレコードが作られる想定
    $this->post('/purchase/address', [
        'postal_code' => '150-0001',
        'address'     => '東京都渋谷区神宮前1-1-1',
        'building'    => 'テストマンション202',
    ])->assertRedirect();

    // 住所が addresses に保存される想定で取得（カラム名は合わせてね）
    $address = Address::where('user_id', $user->id)->latest()->first();

    // 購入確定
    $this->post("/purchase/{$item->id}", [
        'payment_method' => 'credit',
    ])->assertRedirect();

    // DBに「item_id」「user_id」「shipping_address_id」が正しく保存されたか
    $this->assertDatabaseHas('orders', [
        'user_id'             => $user->id,
        'item_id'             => $item->id,
        'shipping_address_id' => $address->id,
    ]);
    }



}

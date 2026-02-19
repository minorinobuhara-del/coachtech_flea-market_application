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
    //$response = $this->get(route('purchase.show', $item));
    //$response->assertSee('カード');
    }

    //配送先変更機能テスト
    /** @test */
    public function shipping_address_registered_on_address_screen_is_reflected_on_purchase_screen()
    {
    $user = User::factory()->create();
    $item = Item::factory()->create();

    $this->actingAs($user);

    // 住所登録
    $this->post("/purchase/address/{$item->id}", [
        'postcode' => '100-0001',
        'address'  => '東京都千代田区千代田1-1',
        'building' => 'テストビル101',
    ])->assertRedirect(route('purchase.show', $item));

    // いまは「DBに保存」より先に、「購入画面に表示される」かで確認（実装次第）
    $response = $this->get(route('purchase.show', $item));
    $response->assertStatus(200);
    $response->assertSee('100-0001');
    $response->assertSee('東京都千代田区千代田1-1');
    $response->assertSee('テストビル101');

    }

    //購入した商品に送付先住所が紐づいて登録されるテスト
    /** @test */
    public function purchased_item_is_saved_with_selected_shipping_address()
    {
    $user = User::factory()->create([
        'postcode' => '000-0000',
        'address' => 'ダミー住所',
        'building' => 'ダミー建物',
    ]);

    $item = Item::factory()->create();

    $this->actingAs($user);

    // 商品に紐づく配送先住所を登録
    $this->post("/purchase/address/{$item->id}", [
        'postcode' => '150-0001',
        'address'     => '東京都渋谷区神宮前1-1-1',
        'building'    => 'テストマンション202',
    ])->assertRedirect(route('purchase.show', $item));

    //  購入する
    $this->post(route('purchase.store', $item), [
        'payment_method' => 'convenience',
    ])->assertRedirect('/mypage?tab=buy');

    // 「購入画面（または購入完了後の画面）」で住所が保持されていることを確認
    $response = $this->get(route('purchase.show', $item));
    $response->assertStatus(200);
    $response->assertSee('150-0001');
    $response->assertSee('東京都渋谷区神宮前1-1-1');
    $response->assertSee('テストマンション202');
}

    }

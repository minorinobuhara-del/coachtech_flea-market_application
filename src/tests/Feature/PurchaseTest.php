<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    private function verify(User $user): void
    {
        $user->forceFill(['email_verified_at' => now()])->save();
    }

    private function makeItem(User $seller): Item
    {
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
    public function user_can_purchase_item()
    {
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();
        $item   = $this->makeItem($seller);

        $this->verify($buyer);

        $response = $this->actingAs($buyer)->post("/purchase/{$item->id}", [
            'payment_method' => 'credit_card',
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('items', [
            'id'      => $item->id,
            'buyer_id'=> $buyer->id,
            'is_sold' => true,
        ]);
    }

    /** @test */
    public function purchased_item_is_shown_as_sold_in_item_list()
    {
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();
        $item   = $this->makeItem($seller);

        $this->verify($buyer);

        $this->actingAs($buyer)->post("/purchase/{$item->id}", [
            'payment_method' => 'credit_card',
        ]);

        // ここはログイン不要（トップは誰でも見れる想定）なので actingAs は不要
        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    /** @test */
    public function purchased_item_is_added_to_profile_purchased_list()
    {
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();
        $item   = $this->makeItem($seller);

        $this->verify($buyer);

        $this->actingAs($buyer)->post("/purchase/{$item->id}", [
            'payment_method' => 'credit_card',
        ]);

        // /mypage は auth + verified のため、buyer を認証済みにしておくのが必須
        $mypage = $this->actingAs($buyer)->get('/mypage?tab=buy');

        $mypage->assertStatus(200);
        $mypage->assertSee($item->name);
    }
}

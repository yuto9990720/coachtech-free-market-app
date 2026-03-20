<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    private User $buyer;
    private User $seller;
    private Item $item;

    protected function setUp(): void
    {
        parent::setUp();

        $condition = Condition::create(['name' => '良好']);
        $category  = Category::create(['name' => 'テスト']);

        $this->seller = User::factory()->create([
            'email'             => 'seller@example.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
            'postal_code'       => '100-0001',
            'address'           => '東京都千代田区千代田1-1',
        ]);

        $this->buyer = User::factory()->create([
            'email'             => 'buyer@example.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
            'postal_code'       => '200-0002',
            'address'           => '東京都新宿区新宿2-2',
        ]);

        $this->item = Item::create([
            'user_id'      => $this->seller->id,
            'condition_id' => $condition->id,
            'name'         => 'テスト商品',
            'description'  => 'テスト説明',
            'price'        => 3000,
            'image'        => 'test.jpg',
        ]);
        $this->item->categories()->attach($category->id);
    }

    public function test_purchase_stores_pending_data_in_session(): void
    {
        $this->actingAs($this->buyer);
        $this->post("/purchase/{$this->item->id}", ['payment_method' => 'card']);
        $this->assertEquals('card', session("pending_purchase_{$this->item->id}")['payment_method']);
    }

    public function test_purchased_item_shows_sold_label(): void
    {
        Purchase::create([
            'user_id'        => $this->buyer->id,
            'item_id'        => $this->item->id,
            'payment_method' => 'card',
            'postal_code'    => '200-0002',
            'address'        => '東京都新宿区新宿2-2',
        ]);
        $this->item->update(['is_sold' => true]);
        $this->actingAs($this->buyer)->get('/')->assertSee('Sold');
    }

    public function test_purchased_item_appears_in_profile(): void
    {
        Purchase::create([
            'user_id'        => $this->buyer->id,
            'item_id'        => $this->item->id,
            'payment_method' => 'card',
            'postal_code'    => '200-0002',
            'address'        => '東京都新宿区新宿2-2',
        ]);
        $this->item->update(['is_sold' => true]);
        $this->actingAs($this->buyer)->get('/mypage?page=buy')
            ->assertStatus(200)
            ->assertSee('テスト商品');
    }

    public function test_payment_method_selection_is_reflected(): void
    {
        $this->actingAs($this->buyer)->get("/purchase/{$this->item->id}")
            ->assertStatus(200)
            ->assertSee('コンビニ支払い')
            ->assertSee('カード支払い');
    }

    public function test_updated_address_reflected_in_purchase_page(): void
    {
        $this->actingAs($this->buyer);
        $this->post("/purchase/address/{$this->item->id}", [
            'postal_code' => '300-0003',
            'address'     => '大阪府大阪市北区梅田3-3',
            'building'    => 'テストビル301',
        ]);
        $this->get("/purchase/{$this->item->id}")
            ->assertSee('300-0003')
            ->assertSee('大阪府大阪市北区梅田3-3');
    }

    public function test_purchase_is_linked_with_shipping_address(): void
    {
        Purchase::create([
            'user_id'        => $this->buyer->id,
            'item_id'        => $this->item->id,
            'payment_method' => 'card',
            'postal_code'    => '300-0003',
            'address'        => '大阪府大阪市北区梅田3-3',
            'building'       => 'テストビル301',
        ]);
        $this->assertDatabaseHas('purchases', [
            'item_id'     => $this->item->id,
            'postal_code' => '300-0003',
            'address'     => '大阪府大阪市北区梅田3-3',
        ]);
    }
}

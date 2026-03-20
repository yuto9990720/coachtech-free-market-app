<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Condition;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $otherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $condition = Condition::create(['name' => '良好']);
        $category  = Category::create(['name' => 'テスト']);

        $this->user = User::factory()->create([
            'email'             => 'user@example.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->otherUser = User::factory()->create([
            'email'             => 'other@example.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // 他ユーザーの商品を3件作成
        for ($i = 1; $i <= 3; $i++) {
            $item = Item::create([
                'user_id'      => $this->otherUser->id,
                'condition_id' => $condition->id,
                'name'         => "テスト商品{$i}",
                'description'  => 'テスト説明',
                'price'        => 1000 * $i,
                'image'        => 'test.jpg',
            ]);
            $item->categories()->attach($category->id);
        }

        // 自分の商品を1件作成
        $myItem = Item::create([
            'user_id'      => $this->user->id,
            'condition_id' => $condition->id,
            'name'         => '自分の商品',
            'description'  => 'テスト説明',
            'price'        => 5000,
            'image'        => 'test.jpg',
        ]);
        $myItem->categories()->attach($category->id);
    }

    /**
     * ID:3 ログアウトができる
     */
    public function test_user_can_logout(): void
    {
        $this->actingAs($this->user);
        $response = $this->post('/logout');
        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /**
     * ID:4 全商品を取得できる（自分の出品商品は除外）
     */
    public function test_all_items_displayed_excluding_own(): void
    {
        $response = $this->actingAs($this->user)->get('/');
        $response->assertStatus(200);

        // 他ユーザーの商品は表示される
        $response->assertSee('テスト商品1');
        // 自分の商品は表示されない
        $response->assertDontSee('自分の商品');
    }

    /**
     * ID:4 購入済み商品は「Sold」と表示される
     */
    public function test_sold_items_show_sold_label(): void
    {
        $item = Item::where('name', 'テスト商品1')->first();
        $item->update(['is_sold' => true]);

        $response = $this->actingAs($this->user)->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /**
     * ID:4 自分が出品した商品は表示されない
     */
    public function test_own_items_not_shown_in_list(): void
    {
        $response = $this->actingAs($this->user)->get('/');
        $response->assertDontSee('自分の商品');
    }

    /**
     * ID:5 いいねした商品だけがマイリストに表示される
     */
    public function test_mylist_shows_only_liked_items(): void
    {
        $item = Item::where('name', 'テスト商品1')->first();
        Like::create(['user_id' => $this->user->id, 'item_id' => $item->id]);

        $response = $this->actingAs($this->user)->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('テスト商品1');
        $response->assertDontSee('テスト商品2');
    }

    /**
     * ID:5 マイリストで購入済み商品は「Sold」と表示される
     */
    public function test_mylist_sold_items_show_sold_label(): void
    {
        $item = Item::where('name', 'テスト商品1')->first();
        Like::create(['user_id' => $this->user->id, 'item_id' => $item->id]);
        $item->update(['is_sold' => true]);

        $response = $this->actingAs($this->user)->get('/?tab=mylist');
        $response->assertSee('Sold');
    }

    /**
     * ID:5 未認証の場合はマイリストに何も表示されない
     */
    public function test_mylist_shows_nothing_for_guests(): void
    {
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertDontSee('テスト商品');
    }

    /**
     * ID:6 「商品名」で部分一致検索ができる
     */
    public function test_search_by_partial_item_name(): void
    {
        $response = $this->get('/?search=テスト商品');
        $response->assertStatus(200);
        $response->assertSee('テスト商品1');
        $response->assertSee('テスト商品2');
    }

    /**
     * ID:6 検索状態がマイリストでも保持されている
     */
    public function test_search_keyword_preserved_in_mylist(): void
    {
        $item = Item::where('name', 'テスト商品1')->first();
        Like::create(['user_id' => $this->user->id, 'item_id' => $item->id]);

        $response = $this->actingAs($this->user)->get('/?tab=mylist&search=テスト商品1');
        $response->assertStatus(200);
        $response->assertSee('テスト商品1');
    }
}

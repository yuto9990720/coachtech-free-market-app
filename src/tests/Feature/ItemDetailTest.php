<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Item $item;

    protected function setUp(): void
    {
        parent::setUp();

        $condition = Condition::create(['name' => '良好']);
        $cat1      = Category::create(['name' => 'メンズ']);
        $cat2      = Category::create(['name' => 'ファッション']);

        $this->user = User::factory()->create([
            'email'             => 'user@example.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $seller = User::factory()->create([
            'email'             => 'seller@example.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->item = Item::create([
            'user_id'      => $seller->id,
            'condition_id' => $condition->id,
            'name'         => 'テスト腕時計',
            'brand'        => 'TestBrand',
            'description'  => 'テスト商品の説明です。',
            'price'        => 15000,
            'image'        => 'test.jpg',
        ]);
        $this->item->categories()->attach([$cat1->id, $cat2->id]);
    }

    /**
     * ID:7 必要な情報が商品詳細ページに表示される
     */
    public function test_item_detail_shows_required_information(): void
    {
        $response = $this->get("/item/{$this->item->id}");

        $response->assertStatus(200);
        $response->assertSee('テスト腕時計');
        $response->assertSee('TestBrand');
        $response->assertSee('15,000');
        $response->assertSee('テスト商品の説明です。');
        $response->assertSee('良好');
    }

    /**
     * ID:7 複数選択されたカテゴリが商品詳細ページに表示されている
     */
    public function test_multiple_categories_shown_in_detail(): void
    {
        $response = $this->get("/item/{$this->item->id}");

        $response->assertSee('メンズ');
        $response->assertSee('ファッション');
    }

    /**
     * ID:8 いいねアイコンを押下することで、いいね数が増加する
     */
    public function test_like_increases_count(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson("/like/{$this->item->id}");

        $response->assertJson(['liked' => true, 'count' => 1]);
        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'item_id' => $this->item->id,
        ]);
    }

    /**
     * ID:8 再度いいねアイコンを押下することでいいねを解除できる
     */
    public function test_like_can_be_toggled_off(): void
    {
        Like::create(['user_id' => $this->user->id, 'item_id' => $this->item->id]);

        $this->actingAs($this->user);
        $response = $this->postJson("/like/{$this->item->id}");

        $response->assertJson(['liked' => false, 'count' => 0]);
        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'item_id' => $this->item->id,
        ]);
    }

    /**
     * ID:9 ログイン済みのユーザーはコメントを送信できる
     */
    public function test_authenticated_user_can_post_comment(): void
    {
        $this->actingAs($this->user);

        $response = $this->post("/comment/{$this->item->id}", [
            'content' => 'テストコメントです。',
        ]);

        $response->assertRedirect("/item/{$this->item->id}");
        $this->assertDatabaseHas('comments', [
            'user_id' => $this->user->id,
            'item_id' => $this->item->id,
            'content' => 'テストコメントです。',
        ]);
    }

    /**
     * ID:9 ログイン前のユーザーはコメントを送信できない
     */
    public function test_guest_cannot_post_comment(): void
    {
        $response = $this->post("/comment/{$this->item->id}", [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseCount('comments', 0);
    }

    /**
     * ID:9 コメントが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_empty_comment_shows_validation_error(): void
    {
        $this->actingAs($this->user);

        $response = $this->post("/comment/{$this->item->id}", [
            'content' => '',
        ]);

        $response->assertSessionHasErrors(['content']);
        $this->assertEquals(
            'コメントを入力してください',
            session('errors')->get('content')[0]
        );
    }

    /**
     * ID:9 コメントが255文字以上の場合、バリデーションメッセージが表示される
     */
    public function test_comment_exceeding_255_chars_shows_validation_error(): void
    {
        $this->actingAs($this->user);

        $response = $this->post("/comment/{$this->item->id}", [
            'content' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors(['content']);
        $this->assertEquals(
            'コメントは255文字以内で入力してください',
            session('errors')->get('content')[0]
        );
    }
}

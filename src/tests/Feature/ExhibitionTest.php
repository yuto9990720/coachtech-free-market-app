<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Condition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        Condition::create(['name' => '良好']);
        Category::create(['name' => 'テスト']);
        $this->user = User::factory()->create([
            'email'             => 'user@example.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }

    public function test_item_can_be_exhibited_with_required_info(): void
    {
        $this->actingAs($this->user);
        $condition = Condition::first();
        $category  = Category::first();
        $image     = UploadedFile::fake()->image('test.png');

        $response = $this->post('/sell', [
            'image'        => $image,
            'category_ids' => [$category->id],
            'condition_id' => $condition->id,
            'name'         => '出品テスト商品',
            'brand'        => 'テストブランド',
            'description'  => '出品テスト説明',
            'price'        => 5000,
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('items', [
            'user_id' => $this->user->id,
            'name'    => '出品テスト商品',
            'price'   => 5000,
        ]);
    }
}

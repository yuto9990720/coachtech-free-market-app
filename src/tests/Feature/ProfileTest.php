<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->user = User::factory()->create([
            'name'              => 'テストユーザー',
            'email'             => 'user@example.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
            'postal_code'       => '123-4567',
            'address'           => '東京都渋谷区渋谷1-1',
            'building'          => 'テストビル101',
        ]);
    }

    public function test_profile_page_shows_required_information(): void
    {
        $response = $this->actingAs($this->user)->get('/mypage');
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
    }

    public function test_profile_edit_shows_current_values_as_defaults(): void
    {
        $response = $this->actingAs($this->user)->get('/mypage/profile');
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区渋谷1-1');
        $response->assertSee('テストビル101');
    }
}

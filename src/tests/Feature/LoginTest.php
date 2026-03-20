<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email'             => 'test@example.com',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
    }

    /**
     * ID:2 メールアドレスが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_email_is_required_for_login(): void
    {
        $response = $this->post('/login', [
            'email'    => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertEquals(
            'メールアドレスを入力してください',
            session('errors')->get('email')[0]
        );
    }

    /**
     * ID:2 パスワードが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_password_is_required_for_login(): void
    {
        $response = $this->post('/login', [
            'email'    => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertEquals(
            'パスワードを入力してください',
            session('errors')->get('password')[0]
        );
    }

    /**
     * ID:2 入力情報が間違っている場合、バリデーションメッセージが表示される
     */
    public function test_invalid_credentials_show_error(): void
    {
        $response = $this->post('/login', [
            'email'    => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
    }

    /**
     * ID:2 正しい情報が入力された場合、ログイン処理が実行される
     */
    public function test_user_can_login_with_correct_credentials(): void
    {
        $response = $this->post('/login', [
            'email'    => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($this->user);
        $response->assertRedirect('/');
    }
}

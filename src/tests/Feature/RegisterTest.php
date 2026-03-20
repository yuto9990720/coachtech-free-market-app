<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ID:1 名前が入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_name_is_required(): void
    {
        $response = $this->post('/register', [
            'name'                  => '',
            'email'                 => 'test@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertEquals(
            'お名前を入力してください',
            session('errors')->get('name')[0]
        );
    }

    /**
     * ID:1 メールアドレスが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_email_is_required(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'テストユーザー',
            'email'                 => '',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertEquals(
            'メールアドレスを入力してください',
            session('errors')->get('email')[0]
        );
    }

    /**
     * ID:1 パスワードが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_password_is_required(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'テストユーザー',
            'email'                 => 'test@example.com',
            'password'              => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertEquals(
            'パスワードを入力してください',
            session('errors')->get('password')[0]
        );
    }

    /**
     * ID:1 パスワードが7文字以下の場合、バリデーションメッセージが表示される
     */
    public function test_password_must_be_at_least_8_characters(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'テストユーザー',
            'email'                 => 'test@example.com',
            'password'              => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertEquals(
            'パスワードは8文字以上で入力してください',
            session('errors')->get('password')[0]
        );
    }

    /**
     * ID:1 確認用パスワードが一致しない場合、バリデーションメッセージが表示される
     */
   public function test_password_confirmation_must_match(): void
{
    $response = $this->post('/register', [
        'name'                  => 'テストユーザー',
        'email'                 => 'test@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'different123',
    ]);

    $response->assertSessionHasErrors(['password']);
    $this->assertEquals(
        'パスワードと一致しません',
        session('errors')->get('password')[0]
    );
}

    /**
     * ID:1 全ての項目が入力されている場合、会員情報が登録され、プロフィール設定画面に遷移される
     */
    public function test_user_can_register_and_redirects_to_profile(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'テストユーザー',
            'email'                 => 'test@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $response->assertRedirect('/mypage/profile');
    }
}

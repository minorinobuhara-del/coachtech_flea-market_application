<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    //名前が未入力の場合
    /** @test */
    public function test_name_is_required()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors([
    'name' => 'お名前を入力してください'
    ]);
    }

    //メール未入力の場合
    /** @test */
    public function test_email_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'test',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['email'=>'メールアドレスを入力してください']);
    }

    //パスワード未入力の場合
    /** @test */
    public function test_password_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['password'=>'パスワードを入力してください']);
    }

    //パスワード7文字以下の場合
    /** @test */
    public function test_password_must_be_at_least_8_characters()
    {
        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $response->assertSessionHasErrors(['password'=>'パスワードは8文字以上で入力してください']);
    }

    //パスワード不一致の場合
    /** @test */
    public function test_password_confirmation_must_match()
    {
        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'different_password',
        ]);

        $response->assertSessionHasErrors(['password'=>'パスワードと一致しません']);
    }

    //正常登録
    /** @test */
    public function test_user_can_register_successfully()
    {
    $response = $this->post('/register', [
        'name' => 'テスト',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);

    $response->assertRedirect('/home'); // 遷移先に合わせて変更
    }
}

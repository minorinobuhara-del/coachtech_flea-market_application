<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    //メール未入力の場合
    /** @test */
    public function email_is_required_for_login()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    //パスワード未入力の場合
    /** @test */
    public function password_is_required_for_login()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    //間違った情報でログインしようとした時
    /** @test */
    public function login_fails_with_invalid_credentials()
    {
    $user = User::factory()->create([
        'email' => 'correct@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email' => 'wrong@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHasErrors(['email']);
    }

    //正常ログイン
    /** @test */
    public function user_can_login_with_correct_credentials()
    {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/profile'); // 遷移先に合わせて変更
    $this->assertAuthenticatedAs($user);
    }

    //ログアウト
    /** @test */
    public function user_can_logout()
    {
    // ① ユーザー作成
    $user = \App\Models\User::factory()->create();

    // ② ログイン状態にする
    $this->actingAs($user);

    // ③ ログアウト実行
    $response = $this->post('/logout');

    // ④ 認証解除されているか確認
    $this->assertGuest();

    // ⑤ リダイレクト確認（通常はトップページ）
    $response->assertRedirect('/');
    }
}

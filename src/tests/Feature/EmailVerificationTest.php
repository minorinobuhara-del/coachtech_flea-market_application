<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\TestCase;
use App\Models\User;

class EmailVerificationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    //テストコード
    /** @test */
    public function user_can_verify_email()
    {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user);

    $verificationUrl = \URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]
    );

    $response = $this->get($verificationUrl);

    $this->assertNotNull($user->fresh()->email_verified_at);

    $response->assertRedirect('/home?verified=1'); // ← あなたの遷移先に合わせる
    }

}

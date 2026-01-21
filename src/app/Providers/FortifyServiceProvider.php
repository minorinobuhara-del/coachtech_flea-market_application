<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        // 会員登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // ログイン画面（必須）
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // ユーザー作成処理
        Fortify::createUsersUsing(CreateNewUser::class);

        //ログイン認証
        Fortify::authenticateUsing(function (Request $request) {

        // FormRequest を手動で使う
        app(\App\Http\Requests\LoginRequest::class)->validateResolved();

        // 認証
        if (!Auth::attempt($request->only('email', 'password'))) {
            return null;
        }

        // 成功時
        return Auth::user();
    });

        // 初回ログイン遷移
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $user = auth()->user();

                    // 初回ログインならプロフィール設定へ
                    if (!$user->profile_completed) {
                        return redirect('/profile');
                    }

                    // 2回目以降
                    return redirect('/mypage');
                }
            };
        });
    }
}

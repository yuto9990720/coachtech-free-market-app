<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
       // 登録後リダイレクト
        $this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            function () {
                return new class implements \Laravel\Fortify\Contracts\RegisterResponse {
                    public function toResponse($request)
                    {
                        return redirect('/mypage/profile');
                    }
                };
            }
        );

        // ログイン後リダイレクト
        $this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            function () {
                return new class implements \Laravel\Fortify\Contracts\LoginResponse {
                    public function toResponse($request)
                    {
                        return redirect('/');
                    }
                };
            }
        );

        // Fortify Actions
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);

        // ビュー
        Fortify::registerView(fn() => view('auth.register'));
        Fortify::loginView(fn() => view('auth.login'));
        Fortify::verifyEmailView(fn() => view('auth.verify-email'));

        // ログイン失敗メッセージをカスタマイズ
        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('email', $request->email)->first();
            if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                return $user;
            }
            // 認証失敗時は null を返す（Fortify がデフォルトエラーを出す）
            return null;
        });

        // レート制限
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = mb_strtolower($request->input(Fortify::username())) . '|' . $request->ip();
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}

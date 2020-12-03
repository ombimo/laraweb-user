<?php
use Illuminate\Support\Facades\Route;
use Ombimo\LarawebUser\Controllers\GoogleLoginController;
use Ombimo\LarawebUser\Controllers\LoginController;
use Ombimo\LarawebUser\Controllers\LogoutController;
use Ombimo\LarawebUser\Controllers\NewPasswordController;
use Ombimo\LarawebUser\Controllers\RegisterController;

if (config('laraweb.multilang')) {
    $prefix = '{locale}/' . config('laraweb-user.prefix');
} else {
    $prefix = config('laraweb-user.prefix');
}

Route::group([
    'prefix' => $prefix,
    'middleware' => 'web'
], function() {
    //artikel index
    Route::get('register', [RegisterController::class, 'get'])->name('user-register');
    Route::post('register', [RegisterController::class, 'post']);

    Route::get('login', [LoginController::class, 'get'])->name('user-login');
    Route::post('login', [LoginController::class, 'post']);

    Route::post('logout', [LogoutController::class, 'post'])->name('user-logout');

    Route::get('login/google', [GoogleLoginController::class, 'redirect'])->name('user-login.google');
    Route::get('login/google/callback', [GoogleLoginController::class, 'callback'])->name('user-login.google-callback');
    Route::get('login/new-password', [NewPasswordController::class, 'get'])->name('user-login.new-password');
    Route::post('login/new-password', [NewPasswordController::class, 'post']);
});

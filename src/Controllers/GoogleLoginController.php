<?php

namespace Ombimo\LarawebUser\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $social = Socialite::driver('google')->user();
            $email = $social->getEmail();
            $name = $social->getName();
            $token = Str::random(32);

            $user = User::firstOrCreate([
                'email' => $email,
            ], [
                'nama' => $name,
                'reset_token' => $token,
            ]);

            Auth::login($user, true);

            //jika passwordnya kosong lempar dulu untuk buat password
            if (empty($user->password) || $user->password == null) {
                return redirect()->route('login.new-password', [
                    'token' => $token,
                ]);
            }

            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }
}

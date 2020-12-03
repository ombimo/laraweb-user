<?php

namespace Ombimo\LarawebUser\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NewPasswordController extends Controller
{
    public function get(Request $request)
    {
        $user = Auth::user();
        $token = $request->query('token');

        if ($user == null) {
            return redirect()->route('home');
        }

        if ($user->reset_token != $token) {
            return redirect()->route('home');
        }

        return view('login.new-password');
    }

    public function post(Request $request)
    {
        $user = Auth::user();
        $token = $request->query('token');
        $password = $request->input('password');

        if ($user == null) {
            return redirect()->route('home');
        }

        if ($user->reset_token != $token) {
            return redirect()->route('home');
        }

        $user->password = Hash::make($password);
        $user->reset_token = null;

        if ($user->save()) {
            return redirect()->route('home');
        }
    }
}

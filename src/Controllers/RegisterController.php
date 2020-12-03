<?php

namespace Ombimo\LarawebUser\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ombimo\LarawebCore\Breadcrumb;

class RegisterController extends Controller
{
    public function get()
    {
        //redirect jika sudah login
        if (Auth::check()) {
            return redirect()->route('home');
        }

        Breadcrumb::add('Register', route('user-register'));

        return view('lw-user.register', [
        ]);
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

         if ($validator->fails()) {
            session()->flash('alert', [
                'type' => 'alert-danger',
                'msg' => 'Register gagal, email atau password tidak boleh kosong'
            ]);
            return redirect()->route('user-register');
        }

        $email = $request->input('email');
        if (User::where('email', $email)->count() >= 1) {
            session()->flash('alert', [
                'type' => 'alert-danger',
                'msg' => 'Register gagal, email sudah digunakan'
            ]);
            return redirect()->route('user-register');
        }

        $user = new User;
        $user->email = $email;
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));

        //todo : redirect menuju halaman sebelumnya, seperti login
        if ($user->save()) {
            Auth::loginUsingId($user->id);
            return redirect()->route('home');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}

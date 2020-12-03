<?php

namespace Ombimo\LarawebUser\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Ombimo\LarawebCore\Breadcrumb;

class LoginController extends Controller
{
    public function get()
    {
        //redirect jika sudah login
        if (Auth::check()) {
            return redirect()->route('home');
        }

        Breadcrumb::add('Login', route('user-login'));

        return view('lw-user.login', [

        ]);
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

         if ($validator->fails()) {
            session()->flash('alert', [
                'type' => 'alert-danger',
                'msg' => 'Login gagal, email atau password tidak boleh kosong'
            ]);
            return redirect()->route('user-login');
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if(Auth::attempt($credentials)) {
            return redirect()->route('home');
        } else {
            session()->flash('alert', [
                'type' => 'alert-danger',
                'msg' => 'Login gagal, email atau password salah'
            ]);
            return redirect()->route('user-login');
        }
    }
}

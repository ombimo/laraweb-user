<?php

namespace Ombimo\LarawebUser\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class LogoutController extends Controller
{
    public function post()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}

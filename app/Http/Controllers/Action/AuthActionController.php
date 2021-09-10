<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function auth;
use function redirect;

class AuthActionController extends Controller
{
    public function login(Request $request)
    {
        if (!auth()->attempt($request->only(["login", "password"])))
            return redirect(route("admin.login"))->withErrors([
                "login"=> "Неправильные данные"
            ]);
        return redirect(route("admin.index"));
    }

    public function logout()
    {
        Auth::logout();

        return redirect(route("index"));
    }
}

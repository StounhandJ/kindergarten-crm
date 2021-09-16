<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function auth;
use function redirect;

class AuthActionController extends Controller
{
    public function login(Request $request)
    {
        if (!auth()->attemptWhen($request->only(["login", "password"]), fn (User $user)=>!is_null($user->getStaff())))
            return redirect(route("admin.login"))->withErrors([
                "login"=> "Неправильные данные"
            ]);
        return redirect(route("login.page"));
    }

    public function logout()
    {
        Auth::logout();

        return redirect(route("index"));
    }
}

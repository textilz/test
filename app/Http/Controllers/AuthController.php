<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return redirect()->route('index')->with('token', $token);
        }

        return redirect()->route('login')->withErrors(['email' => 'Неверный логин']);
    }

    // Метод для выхода из системы
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('index');
    }
}

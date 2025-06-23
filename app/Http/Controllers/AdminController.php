<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {
        return view('admin.user.createUser', [
            'roles' => Role::all()
        ]);
    }

    public function store(Request $request)
    {
        // Валидация входящих данных
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthday' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string', // Добавлено подтверждение пароля
            'role_id' => 'required|exists:roles,id',
        ]);

        // Создание нового пользователя
        User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Хеширование пароля
            'role_id' => $request->role_id,
        ]);

        // Перенаправление на страницу с сообщением об успешном создании
        return redirect()->route('adminStoreUserWeb')->with('success', 'Пользователь создан');
    }
}

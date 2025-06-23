<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Получаем всех пользователей из базы данных
        $users = User::with('role')->get(); // Предполагается, что у вас есть связь с моделью Role

        return view('admin.user.users', compact('users'));
    }
}

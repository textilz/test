<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function show($id)
    {
        return view('admin.groups.index', [
            'courseId' => $id,
            'groups' => Group::where('course_id', $id)->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:20',
            'course_id' => 'required|integer|exists:courses,id',
        ]);

        Group::create($validated);

        return redirect()->route('adminGroup', ['id' => $request->course_id])->with('success', 'Курс успешно создан');
    }

    public function showUsers($courseId, $groupId)
    {
        $users = UserGroup::where('group_id', $groupId)->with(['user'])->get();

        return view('admin.groups.users', [
            'courseId' => $courseId,
            'groupId' => $groupId,
            'users' => $users
        ]);
    }

    public function storeUser(Request $request, $courseId, $groupId)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        UserGroup::create([
            'group_id' => $groupId,
            'user_id' => $request->user_id
        ]);

        return redirect()->route('adminGroupUsers', ['courseId' => $courseId, 'groupId' => $groupId])->with('success', 'Ученик добавлен');
    }

    public function destroyUser($courseId, $groupId, $userId)
    {

        UserGroup::where('group_id', $groupId)->where('user_id', $userId)->delete();

        return redirect()->route('adminGroupUsers', ['courseId' => $courseId, 'groupId' => $groupId])->with('success', 'Ученик добавлен');

    }
}

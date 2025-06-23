<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDate;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserDateController extends Controller
{
    public function index($courseId, $groupId, $lessonId)
    {
        $userGroups = UserGroup::where('group_id', $groupId)->get();
        $userDates = UserDate::where('lesson_id', $lessonId)->pluck('user_id')->toArray();

        $result = $userGroups->map(function ($userGroup) use ($userDates) {
            $user = User::find($userGroup->user_id);
            return [
                'id' => $userGroup->id,
                'user_id' => $userGroup->user_id,
                'name' => $user->surname . ' ' . $user->name,
                'hasLesson' => in_array($userGroup->user_id, $userDates)
            ];
        });

        return view('admin.lessons.dates', [
            'courseId' => $courseId,
            'groupId' => $groupId,
            'lessonId' => $lessonId,
            'users' => $result
        ]);
    }

    public function store(Request $request, $courseId, $groupId, $lessonId)
    {
        UserDate::where('lesson_id', $lessonId)->delete();

        foreach ($request->all() as $key => $value) {
            if ($key == '_token') { continue; }
            $slice = explode('-', $key);
            if ($slice[0] == 'user') {
                UserDate::create([
                    'lesson_id' => $lessonId,
                    'user_id' => $slice[1],
                ]);
            }

        }
        return redirect()->route('adminDates', [
            'courseId' => $courseId,
            'groupId' => $groupId,
            'lessonId' => $lessonId,
        ])->with('success', 'Посещение добавлено');
    }
}

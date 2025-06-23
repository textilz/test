<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index($courseId, $groupId)
    {
        return view('admin.lessons.index', [
            'courseId' => $courseId,
            'groupId' => $groupId,
            'lessons' => Lesson::where('group_id', $groupId)->get()
        ]);
    }

    public function store(Request $request, $courseId, $groupId)
    {
        $validated = $request->validate([
            'date' => 'required',
        ]);

        Lesson::create([
            'group_id' => $groupId,
            'date' => $request->date
        ]);

        return redirect()->route('adminGroupLessons', [
            'courseId' => $courseId,
            'groupId' => $groupId,
        ])->with('success', 'Занятие добавлено');

    }
}

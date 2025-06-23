<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index($courseId, $groupId, $lessonId)
    {
        return view('admin.tasks.index', [
            'courseId' => $courseId,
            'groupId' => $groupId,
            'lessonId' => $lessonId,
            'tasks' => Task::where('lesson_id', $lessonId)->get()
        ]);
    }

    public function store(Request $request, $courseId, $groupId, $lessonId)
    {
        Task::create([
            'lesson_id' => $lessonId,
            'name' => $request->name,
            'homework' => $request->homework ? true : false,
        ]);

        return redirect()->route('adminTasks', [
            'courseId' => $courseId,
            'groupId' => $groupId,
            'lessonId' => $lessonId,
        ])->with('success', 'Задание добавлено');

    }
}

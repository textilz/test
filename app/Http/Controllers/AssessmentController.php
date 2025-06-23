<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Task;
use App\Models\User;
use App\Models\UserDate;
use App\Models\UserGroup;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index($courseId, $groupId, $lessonId, $taskId)
    {
        $userGroups = UserGroup::where('group_id', $groupId)->get();
        $assessments = Assessment::where('task_id', $taskId)->pluck('user_id')->toArray();

        $result = $userGroups->map(function ($userGroup) use ($assessments, $taskId) {
            $user = User::find($userGroup->user_id);
            $assessmentValue = null;
            if (in_array($userGroup->user_id, $assessments)) {
                $assessment = Assessment::where('task_id', $taskId)->where('user_id', $user->id)->first();
                $assessmentValue = $assessment ? $assessment->value : null; // Проверка на наличие записи
            }

            return [
                'id' => $userGroup->id,
                'user_id' => $userGroup->user_id,
                'name' => $user->surname . ' ' . $user->name,
                'assessment' => $assessmentValue,
            ];
        });

        return view('admin.tasks.assessment', [
            'courseId' => $courseId,
            'groupId' => $groupId,
            'lessonId' => $lessonId,
            'taskId' => $taskId,
            'users' => $result
        ]);
    }

    public function store(Request $request, $courseId, $groupId, $lessonId, $taskId)
    {
        Assessment::where('task_id', $taskId)->delete();

        foreach ($request->all() as $key => $value) {
            if ($key == '_token') { continue; }
            $slice = explode('-', $key);
            if ($slice[0] == 'user') {
                Assessment::create([
                    'task_id' => $taskId,
                    'user_id' => $slice[1],
                    'value' => $value,
                ]);
            }

        }

        return redirect()->route('adminAssessment', [
            'courseId' => $courseId,
            'groupId' => $groupId,
            'lessonId' => $lessonId,
            'taskId' => $taskId,
        ])->with('success', 'Оценка добавлена');
    }
}

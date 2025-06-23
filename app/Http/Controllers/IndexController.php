<?php

namespace App\Http\Controllers;

use App\Models\Adv;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        return view('index', [
            'advs' => Adv::all()
        ]);
    }
    public function schedule(Request $request)
    {
        Carbon::setLocale('ru');

        $userId = Auth::id();

        $weekOffset = request()->integer('week', 0);

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY)->addWeeks($weekOffset);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY)->addWeeks($weekOffset);


        // Получаем ID групп, в которых состоит пользователь
        $groupIds = DB::table('user_groups')
            ->where('user_id', $userId)
            ->pluck('group_id');

        // Получаем уроки на неделю для этих групп
        $lessons = DB::table('lessons')
            ->join('groups', 'lessons.group_id', '=', 'groups.id')
            ->join('courses', 'groups.course_id', '=', 'courses.id')
            ->join('subjects', 'courses.subject_id', '=', 'subjects.id')
            ->select(
                'lessons.id as lesson_id',
                'lessons.date',
                'subjects.name as subject_name'
            )
            ->whereIn('lessons.group_id', $groupIds)
            ->whereBetween('lessons.date', [$startOfWeek, $endOfWeek])
            ->orderBy('lessons.date')
            ->get();

        $lessonIds = $lessons->pluck('lesson_id');

        // Получаем задания по урокам
        $tasks = DB::table('tasks')
            ->whereIn('lesson_id', $lessonIds)
            ->get()
            ->groupBy('lesson_id');

        // Получаем оценки пользователя по заданиям
        $taskIds = $tasks->flatten()->pluck('id');
        $assessments = DB::table('assessments')
            ->whereIn('task_id', $taskIds)
            ->where('user_id', $userId)
            ->get()
            ->keyBy('task_id');

        $result = [];
        $period = \Carbon\CarbonPeriod::create($startOfWeek, $endOfWeek);

        foreach ($period as $day) {
            $dateKey = $day->format('Y-m-d');

            $result[$dateKey] = [
                'date' => $dateKey,
                'date_formatted' => $day->format('d.m.Y'),
                'weekday' => $this->mb_ucfirst($day->translatedFormat('l')),
                'lessons' => [],
            ];
        }

        foreach ($lessons as $lesson) {
            $date = Carbon::parse($lesson->date);
            $dateKey = $date->format('Y-m-d');
            $time = $date->format('H:i');
            $timeEnd = $date->copy()->addMinutes(90)->format('H:i');

            $lessonTasks = $tasks[$lesson->lesson_id] ?? collect();

            $taskList = $lessonTasks->map(function ($task) use ($assessments) {
                return [
                    'name' => $task->name,
                    'homework' => (bool) $task->homework,
                    'assessment' => $assessments[$task->id]->value ?? null,
                ];
            });

            if (!isset($result[$dateKey])) {
                $result[$dateKey] = [
                    'date' => $dateKey,
                    'date_formatted' => $date->format('d.m.Y'),
                    'weekday' => $this->mb_ucfirst($date->translatedFormat('l')),
                    'lessons' => [],
                ];
            }

            $result[$dateKey]['lessons'][] = [
                'time' => $time,
                'time_end' => $timeEnd,
                'subject' => $lesson->subject_name,
                'tasks' => $taskList->toArray(),
            ];
        }

        ksort($result);

        return view('schedule', [
            'data' => $result,
            'week_offset' => $weekOffset,
            'start_of_week' => $startOfWeek->format('d.m.Y'),
            'end_of_week' => $endOfWeek->format('d.m.Y'),
            ]);
    }

    private function mb_ucfirst($string, $encoding = 'UTF-8')
    {
        return mb_strtoupper(mb_substr($string, 0, 1, $encoding), $encoding)
            . mb_substr($string, 1, null, $encoding);
    }
}

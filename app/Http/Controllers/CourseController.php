<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Organization;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 3) {
            $courses = Course::where('teacher_id', Auth::user()->id)->with(['teacher', 'organization', 'subject'])->get();
        } else {
            $courses = Course::with(['teacher', 'organization', 'subject'])->get();
        }

        return view('admin.courses.index', compact('courses'));
    }

    public function storeWeb()
    {
        $teachers = User::where('role_id', 3)->get();
        $organizations = Organization::all();
        $subjects = Subject::all();

        return view('admin.courses.create', compact('teachers', 'organizations', 'subjects'));
    }

    // Создать новый курс
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|integer|exists:users,id',
            'organization_id' => 'required|integer|exists:organizations,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'cost' => 'required|numeric|min:0',
        ]);

        Course::create($validated);

        return redirect()->route('adminCourse')->with('success', 'Курс успешно создан');
    }

    public function destroy($id)
    {
        Course::destroy($id);
        return redirect()->route('adminCourse');
    }
}

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDateController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/login', function () {
    return view('login');
})->name('loginWeb');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::middleware('auth:sanctum')->middleware('teacher')->group(function () {
//    Route::get('/schedule', [UserDateController::class, 'index'])->name('scheduleWeb');
//    Route::get('/journal', [UserDateController::class, 'index'])->name('scheduleWeb');
//    Route::post('/schedule', [UserDateController::class, 'store'])->name('schedule');
    Route::middleware('admin')->group(function () {
        Route::get('/users/store', [AdminController::class, 'index'])->name('adminStoreUserWeb');
        Route::post('/users/store', [AdminController::class, 'store'])->name('adminStoreUser');
        Route::get('/users/', [UserController::class, 'index'])->name('adminUser');
        Route::get('/courses/{id}/destroy', [CourseController::class, 'destroy'])->name('adminDestroyCourse');
        Route::get('/groups/{id}/destroy', [GroupController::class, 'destroy'])->name('adminDestroyGroup');
        Route::get('/courses/{courseId}/{groupId}/users/destroy', [GroupController::class, 'destroy'])->name('adminDestroyUserGroup');
        Route::get('/courses/{courseId}/{groupId}/{lessonId}/destroy', [LessonController::class, 'destroy'])->name('adminDestroyLesson');
    });
    Route::get('/courses/{courseId}/{groupId}/{lessonId}/tasks/destroy', [TaskController::class, 'destroy'])->name('adminDestroyTasks');


    Route::get('/courses/store', [CourseController::class, 'storeWeb'])->name('adminStoreCourseWeb');
    Route::post('/courses/store', [CourseController::class, 'store'])->name('adminStoreCourse');
    Route::get('/courses/', [CourseController::class, 'index'])->name('adminCourse');


    Route::get('/courses/{id}/groups', [GroupController::class, 'show'])->name('adminGroup');
    Route::post('/groups/store', [GroupController::class, 'store'])->name('adminStoreGroup');


    Route::get('/courses/{courseId}/{groupId}/users', [GroupController::class, 'showUsers'])->name('adminGroupUsers');
    Route::post('/courses/{courseId}/{groupId}/users', [GroupController::class, 'storeUser'])->name('adminStoreUserGroup');
    Route::get('/courses/{courseId}/{groupId}/lessons', [LessonController::class, 'index'])->name('adminGroupLessons');
    Route::post('/courses/{courseId}/{groupId}/lessons', [LessonController::class, 'store'])->name('adminStoreLesson');
    Route::get('/courses/{courseId}/{groupId}/{lessonId}/tasks', [TaskController::class, 'index'])->name('adminTasks');
    Route::post('/courses/{courseId}/{groupId}/{lessonId}/tasks', [TaskController::class, 'store'])->name('adminStoreTasks');
    Route::get('/courses/{courseId}/{groupId}/{lessonId}/dates', [UserDateController::class, 'index'])->name('adminDates');
    Route::post('/courses/{courseId}/{groupId}/{lessonId}/dates', [UserDateController::class, 'store'])->name('adminStoreDates');
    Route::get('/courses/{courseId}/{groupId}/{lessonId}/{taskId}/assessment', [AssessmentController::class, 'index'])->name('adminAssessment');
    Route::post('/courses/{courseId}/{groupId}/{lessonId}/{taskId}/assessment', [AssessmentController::class, 'store'])->name('adminStoreAssessment');
});

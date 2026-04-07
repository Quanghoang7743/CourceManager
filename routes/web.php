<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/courses/trashed', [CourseController::class, 'trashed'])->name('courses.trashed');
Route::patch('/courses/{course}/restore', [CourseController::class, 'restore'])->name('courses.restore');
Route::resource('courses', CourseController::class)->except('show');

Route::resource('lessons', LessonController::class)->except('show');

Route::resource('enrollments', EnrollmentController::class)->only(['index', 'create', 'store', 'destroy']);

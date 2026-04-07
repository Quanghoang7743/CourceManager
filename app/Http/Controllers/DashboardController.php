<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCourses = Course::count();
        $totalStudents = Student::count();

        $totalRevenue = DB::table('enrollments')
            ->join('courses', 'courses.id', '=', 'enrollments.course_id')
            ->sum('courses.price');

        $topCourse = Course::query()
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->orderBy('name')
            ->first();

        $latestCourses = Course::query()->withCount(['lessons', 'enrollments'])->latest()->take(5)->get();

        return view('dashboard.index', compact('totalCourses', 'totalStudents', 'totalRevenue', 'topCourse', 'latestCourses'));
    }
}

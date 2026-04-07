<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::query()->withCount('enrollments')->orderBy('name')->get();

        $query = Enrollment::query()->with(['student', 'course'])->latest();

        if ($request->filled('course_id')) {
            $query->where('course_id', (int) $request->input('course_id'));
        }

        $enrollments = $query->paginate(15)->withQueryString();

        return view('enrollments.index', compact('courses', 'enrollments'));
    }

    public function create()
    {
        $courses = Course::query()->where('status', 'published')->orderBy('name')->get();

        return view('enrollments.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $student = Student::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'student_code' => 'HV-'.Str::upper(Str::random(8)),
            ]
        );

        if ($student->name !== $validated['name']) {
            $student->update(['name' => $validated['name']]);
        }

        $exists = Enrollment::query()
            ->where('student_id', $student->id)
            ->where('course_id', $validated['course_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Hoc vien da dang ky khoa hoc nay.');
        }

        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $validated['course_id'],
        ]);

        return redirect()->route('enrollments.index')->with('success', 'Dang ky khoa hoc thanh cong.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')->with('success', 'Da huy dang ky.');
    }
}

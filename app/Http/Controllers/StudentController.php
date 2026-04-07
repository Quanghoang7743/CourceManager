<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::withCount('courses')->withSum('courses', 'credits')->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'student_code' => ['required', 'string', 'max:20', 'unique:students,student_code'],
        ]);

        Student::create($validated);

        return redirect('/students')->with('success', 'Thêm sinh viên thành công.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect('/students')->with('success', 'Xóa sinh viên thành công.');
    }
}

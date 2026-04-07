<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::query()->orderBy('name')->get();

        $lessons = Lesson::query()
            ->with('course')
            ->when($request->filled('course_id'), fn ($query) => $query->where('course_id', (int) $request->input('course_id')))
            ->orderBy('course_id')
            ->orderBy('order')
            ->paginate(15)
            ->withQueryString();

        return view('lessons.index', compact('lessons', 'courses'));
    }

    public function create()
    {
        $courses = Course::query()->orderBy('name')->get();

        return view('lessons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'video_url' => ['nullable', 'url'],
            'order' => ['required', 'integer', 'min:1'],
        ]);

        Lesson::create($validated);

        return redirect()->route('lessons.index')->with('success', 'Them bai hoc thanh cong.');
    }

    public function edit(Lesson $lesson)
    {
        $courses = Course::query()->orderBy('name')->get();

        return view('lessons.edit', compact('lesson', 'courses'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'video_url' => ['nullable', 'url'],
            'order' => ['required', 'integer', 'min:1'],
        ]);

        $lesson->update($validated);

        return redirect()->route('lessons.index')->with('success', 'Cap nhat bai hoc thanh cong.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('lessons.index')->with('success', 'Xoa bai hoc thanh cong.');
    }
}

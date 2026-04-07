<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query()->withCount(['lessons', 'enrollments']);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->string('name').'%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->input('price_max'));
        }

        match ($request->input('sort', 'created_desc')) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'students_desc' => $query->orderByDesc('enrollments_count'),
            'students_asc' => $query->orderBy('enrollments_count'),
            'created_asc' => $query->orderBy('created_at'),
            default => $query->orderByDesc('created_at'),
        };

        $courses = $query->paginate(8)->withQueryString();

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gt:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $imagePath = $request->file('image')->store('courses', 'public');

        Course::create([
            'name' => $validated['name'],
            'course_code' => $this->makeCourseCode(),
            'credits' => 1,
            'slug' => $this->makeUniqueSlug($validated['name']),
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('courses.index')->with('success', 'Them khoa hoc thanh cong.');
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gt:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $course->image_path;

        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('image')->store('courses', 'public');
        }

        $course->update([
            'name' => $validated['name'],
            'slug' => $course->name !== $validated['name'] ? $this->makeUniqueSlug($validated['name'], $course->id) : $course->slug,
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('courses.index')->with('success', 'Cap nhat khoa hoc thanh cong.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Khoa hoc da duoc chuyen vao thung rac.');
    }

    public function trashed()
    {
        $courses = Course::onlyTrashed()->withCount(['lessons', 'enrollments'])->latest('deleted_at')->paginate(8);

        return view('courses.trashed', compact('courses'));
    }

    public function restore(int $course)
    {
        $restored = Course::onlyTrashed()->findOrFail($course);
        $restored->restore();

        return redirect()->route('courses.trashed')->with('success', 'Khoi phuc khoa hoc thanh cong.');
    }

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 1;

        while (
            Course::query()
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function makeCourseCode(): string
    {
        do {
            $code = 'CRS'.str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Course::where('course_code', $code)->exists());

        return $code;
    }
}

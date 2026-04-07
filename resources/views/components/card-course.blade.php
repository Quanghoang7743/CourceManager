@props(['course'])

<article class="course-card">
    <div class="course-thumb-wrap">
        @if ($course->image_path)
            <img class="course-thumb" src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->name }}">
        @else
            <div class="course-thumb placeholder">No Image</div>
        @endif
    </div>

    <div class="course-body">
        <div class="course-head">
            <h3>{{ $course->name }}</h3>
            <x-badge-status :status="$course->status" />
        </div>
        <p class="course-sub">{{ number_format($course->price, 0, ',', '.') }} VND</p>
        <p class="course-sub">{{ $course->lessons_count }} bai hoc · {{ $course->enrollments_count }} hoc vien</p>
    </div>
</article>

@extends('layouts.app')

@section('title', 'Them bai hoc')

@section('content')
<div class="header">
    <div>
        <h1>Them bai hoc</h1>
        <p class="subtitle">Them bai hoc vao khoa hoc</p>
    </div>
</div>

<form method="POST" action="{{ route('lessons.store') }}">
    @csrf

    <div class="field">
        <label for="course_id">Khoa hoc</label>
        <select id="course_id" name="course_id" required>
            <option value="">Chon khoa hoc</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" @selected((string) old('course_id') === (string) $course->id)>{{ $course->name }}</option>
            @endforeach
        </select>
        @error('course_id') <p class="error-text">{{ $message }}</p> @enderror
    </div>

    <x-form.input name="title" label="Tieu de bai hoc" required="true" />
    <x-form.textarea name="content" label="Noi dung" required="true" />
    <x-form.input name="video_url" type="url" label="Video URL" placeholder="https://..." />
    <x-form.input name="order" type="number" label="Thu tu" min="1" value="1" required="true" />

    <div class="actions">
        <button class="btn" type="submit">Luu</button>
        <a class="btn btn-outline" href="{{ route('lessons.index') }}">Quay lai</a>
    </div>
</form>
@endsection

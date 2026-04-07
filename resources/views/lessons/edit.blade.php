@extends('layouts.app')

@section('title', 'Cap nhat bai hoc')

@section('content')
<div class="header">
    <div>
        <h1>Cap nhat bai hoc</h1>
        <p class="subtitle">Sua thong tin bai hoc va thu tu hien thi</p>
    </div>
</div>

<form method="POST" action="{{ route('lessons.update', $lesson) }}">
    @csrf
    @method('PUT')

    <div class="field">
        <label for="course_id">Khoa hoc</label>
        <select id="course_id" name="course_id" required>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" @selected((string) old('course_id', $lesson->course_id) === (string) $course->id)>{{ $course->name }}</option>
            @endforeach
        </select>
        @error('course_id') <p class="error-text">{{ $message }}</p> @enderror
    </div>

    <x-form.input name="title" label="Tieu de bai hoc" :value="$lesson->title" required="true" />
    <x-form.textarea name="content" label="Noi dung" :value="$lesson->content" required="true" />
    <x-form.input name="video_url" type="url" label="Video URL" :value="$lesson->video_url" />
    <x-form.input name="order" type="number" label="Thu tu" min="1" :value="$lesson->order" required="true" />

    <div class="actions">
        <button class="btn" type="submit">Cap nhat</button>
        <a class="btn btn-outline" href="{{ route('lessons.index') }}">Quay lai</a>
    </div>
</form>
@endsection

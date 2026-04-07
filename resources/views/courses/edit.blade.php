@extends('layouts.app')

@section('title', 'Cap nhat khoa hoc')

@section('content')
<div class="header">
    <div>
        <h1>Cap nhat khoa hoc</h1>
        <p class="subtitle">Chinh sua thong tin hien tai cua khoa hoc</p>
    </div>
</div>

<form method="POST" action="{{ route('courses.update', $course) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <x-form.input name="name" label="Ten khoa hoc" :value="$course->name" required="true" />
    <x-form.input name="price" type="number" label="Gia" min="1" step="1000" :value="$course->price" required="true" />
    <x-form.textarea name="description" label="Mo ta" :value="$course->description" />
    <x-form.select
        name="status"
        label="Trang thai"
        :options="['draft' => 'Draft', 'published' => 'Published']"
        :value="$course->status"
        required="true"
    />

    <div class="field">
        <label for="image">Anh khoa hoc (co the bo qua)</label>
        <input type="file" id="image" name="image" accept="image/*">
        @error('image') <p class="error-text">{{ $message }}</p> @enderror
    </div>

    @if($course->image_path)
        <div class="field">
            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->name }}" style="max-width:320px; border-radius:10px; border:1px solid #e2e8f0;">
        </div>
    @endif

    <div class="actions">
        <button class="btn" type="submit">Cap nhat</button>
        <a class="btn btn-outline" href="{{ route('courses.index') }}">Quay lai</a>
    </div>
</form>
@endsection

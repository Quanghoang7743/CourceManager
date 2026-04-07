@extends('layouts.app')

@section('title', 'Dang ky khoa hoc')

@section('content')
<div class="header">
    <div>
        <h1>Dang ky khoa hoc</h1>
        <p class="subtitle">Chon khoa hoc va nhap thong tin hoc vien</p>
    </div>
</div>

<form method="POST" action="{{ route('enrollments.store') }}">
    @csrf

    <div class="field">
        <label for="course_id">Khoa hoc</label>
        <select id="course_id" name="course_id" required>
            <option value="">Chon khoa hoc</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" @selected((string) old('course_id') === (string) $course->id)>
                    {{ $course->name }} - {{ number_format($course->price, 0, ',', '.') }} VND
                </option>
            @endforeach
        </select>
        @error('course_id') <p class="error-text">{{ $message }}</p> @enderror
    </div>

    <x-form.input name="name" label="Ten hoc vien" required="true" />
    <x-form.input name="email" type="email" label="Email" required="true" />

    <div class="actions">
        <button class="btn" type="submit">Dang ky</button>
        <a class="btn btn-outline" href="{{ route('enrollments.index') }}">Quay lai</a>
    </div>
</form>
@endsection

@extends('layouts.app')

@section('title', 'Them khoa hoc')

@section('content')
<div class="header">
    <div>
        <h1>Them khoa hoc</h1>
        <p class="subtitle">Tao khoa hoc moi voi anh, gia va trang thai</p>
    </div>
</div>

<form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data">
    @csrf

    <x-form.input name="name" label="Ten khoa hoc" required="true" />
    <x-form.input name="price" type="number" label="Gia" min="1" step="1000" required="true" />
    <x-form.textarea name="description" label="Mo ta" />
    <x-form.select
        name="status"
        label="Trang thai"
        :options="['draft' => 'Draft', 'published' => 'Published']"
        value="draft"
        required="true"
    />

    <div class="field">
        <label for="image">Anh khoa hoc</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        @error('image') <p class="error-text">{{ $message }}</p> @enderror
    </div>

    <div class="actions">
        <button class="btn" type="submit">Luu</button>
        <a class="btn btn-outline" href="{{ route('courses.index') }}">Quay lai</a>
    </div>
</form>
@endsection

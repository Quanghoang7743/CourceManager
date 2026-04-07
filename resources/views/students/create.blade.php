@extends('layouts.app')
@section('title', 'Thêm sinh viên')
@section('content')
<h1 style="margin-bottom:20px;">Thêm sinh viên</h1>
<div class="glass-form">
    <form action="/students" method="POST">
        @csrf
        <div class="field">
            <label for="student_code">Mã số sinh viên</label>
            <input type="text" id="student_code" name="student_code" value="{{ old('student_code') }}" required placeholder="VD: SV001">
            @error('student_code') <p class="error-text">{{ $message }}</p> @enderror
        </div>
        <div class="field">
            <label for="name">Họ và tên</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="VD: Nguyễn Văn A">
            @error('name') <p class="error-text">{{ $message }}</p> @enderror
        </div>
        <div class="actions">
            <button class="btn" type="submit">Lưu</button>
            <a class="btn btn-outline" href="/students">Quay lại</a>
        </div>
    </form>
</div>
@endsection

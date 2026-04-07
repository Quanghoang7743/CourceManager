@extends('layouts.app')

@section('title', 'Quan ly khoa hoc')

@section('content')
<div class="header">
    <div>
        <h1>Danh sach khoa hoc</h1>
        <p class="subtitle">Tim kiem, loc, sap xep va quan ly khoa hoc</p>
    </div>
    <div class="actions">
        <a class="btn btn-outline" href="{{ route('courses.trashed') }}">Thung rac</a>
        <a class="btn" href="{{ route('courses.create') }}">Them khoa hoc</a>
    </div>
</div>

<form method="GET" action="{{ route('courses.index') }}" class="filters">
    <input type="text" name="name" value="{{ request('name') }}" placeholder="Ten khoa hoc">
    <input type="number" min="0" name="price_min" value="{{ request('price_min') }}" placeholder="Gia tu">
    <input type="number" min="0" name="price_max" value="{{ request('price_max') }}" placeholder="Gia den">
    <select name="status">
        <option value="">Trang thai</option>
        <option value="draft" @selected(request('status') === 'draft')>Draft</option>
        <option value="published" @selected(request('status') === 'published')>Published</option>
    </select>
    <select name="sort">
        <option value="created_desc" @selected(request('sort', 'created_desc') === 'created_desc')>Moi nhat</option>
        <option value="created_asc" @selected(request('sort') === 'created_asc')>Cu nhat</option>
        <option value="price_asc" @selected(request('sort') === 'price_asc')>Gia tang dan</option>
        <option value="price_desc" @selected(request('sort') === 'price_desc')>Gia giam dan</option>
        <option value="students_desc" @selected(request('sort') === 'students_desc')>Hoc vien nhieu</option>
        <option value="students_asc" @selected(request('sort') === 'students_asc')>Hoc vien it</option>
    </select>
    <button class="btn" type="submit">Ap dung</button>
</form>

<x-table>
    <thead>
    <tr>
        <th>Anh</th>
        <th>Ten</th>
        <th>Gia</th>
        <th>Trang thai</th>
        <th>So bai hoc</th>
        <th>Hoc vien</th>
        <th>Thao tac</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($courses as $course)
        <tr>
            <td>
                @if ($course->image_path)
                    <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->name }}" style="width:62px; height:42px; object-fit:cover; border-radius:8px;">
                @else
                    <span class="subtitle">No image</span>
                @endif
            </td>
            <td>
                <strong>{{ $course->name }}</strong><br>
                <span class="subtitle">/{{ $course->slug }}</span>
            </td>
            <td>{{ number_format($course->price, 0, ',', '.') }} VND</td>
            <td><x-badge-status :status="$course->status" /></td>
            <td>{{ $course->lessons_count }}</td>
            <td>{{ $course->enrollments_count }}</td>
            <td>
                <div class="actions">
                    <a class="btn btn-sm btn-outline" href="{{ route('courses.edit', $course) }}">Sua</a>
                    <form action="{{ route('courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Xoa khoa hoc nay?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Xoa</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="subtitle">Chua co khoa hoc.</td>
        </tr>
    @endforelse
    </tbody>
</x-table>

<div class="pagination">{{ $courses->links() }}</div>

@if ($courses->count())
    <div class="cards">
        @foreach($courses->take(3) as $course)
            <x-card-course :course="$course" />
        @endforeach
    </div>
@endif
@endsection

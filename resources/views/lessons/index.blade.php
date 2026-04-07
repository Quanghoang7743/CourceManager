@extends('layouts.app')

@section('title', 'Quan ly bai hoc')

@section('content')
<div class="header">
    <div>
        <h1>Danh sach bai hoc</h1>
        <p class="subtitle">Hien thi bai hoc theo tung khoa hoc, sap xep theo thu tu</p>
    </div>
    <a class="btn" href="{{ route('lessons.create') }}">Them bai hoc</a>
</div>

<form method="GET" action="{{ route('lessons.index') }}" class="filters" style="grid-template-columns: 1fr 180px;">
    <select name="course_id">
        <option value="">Tat ca khoa hoc</option>
        @foreach($courses as $course)
            <option value="{{ $course->id }}" @selected((string) request('course_id') === (string) $course->id)>{{ $course->name }}</option>
        @endforeach
    </select>
    <button class="btn" type="submit">Loc</button>
</form>

<x-table>
    <thead>
    <tr>
        <th>Khoa hoc</th>
        <th>Tieu de</th>
        <th>Video URL</th>
        <th>Thu tu</th>
        <th>Thao tac</th>
    </tr>
    </thead>
    <tbody>
    @forelse($lessons as $lesson)
        <tr>
            <td>{{ $lesson->course->name }}</td>
            <td>{{ $lesson->title }}</td>
            <td>
                @if($lesson->video_url)
                    <a href="{{ $lesson->video_url }}" target="_blank">Mo video</a>
                @else
                    <span class="subtitle">Khong co</span>
                @endif
            </td>
            <td>{{ $lesson->order }}</td>
            <td>
                <div class="actions">
                    <a class="btn btn-sm btn-outline" href="{{ route('lessons.edit', $lesson) }}">Sua</a>
                    <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" onsubmit="return confirm('Xoa bai hoc nay?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Xoa</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="subtitle">Chua co bai hoc.</td></tr>
    @endforelse
    </tbody>
</x-table>

<div class="pagination">{{ $lessons->links() }}</div>
@endsection

@extends('layouts.app')

@section('title', 'Danh sach dang ky')

@section('content')
<div class="header">
    <div>
        <h1>Quan ly dang ky khoa hoc</h1>
        <p class="subtitle">Danh sach hoc vien theo tung khoa hoc va tong so dang ky</p>
    </div>
    <a class="btn" href="{{ route('enrollments.create') }}">Dang ky moi</a>
</div>

<x-table>
    <thead>
    <tr>
        <th>Khoa hoc</th>
        <th>Tong hoc vien</th>
    </tr>
    </thead>
    <tbody>
    @forelse($courses as $course)
        <tr>
            <td>{{ $course->name }}</td>
            <td>{{ $course->enrollments_count }}</td>
        </tr>
    @empty
        <tr><td colspan="2" class="subtitle">Chua co khoa hoc.</td></tr>
    @endforelse
    </tbody>
</x-table>

<form method="GET" action="{{ route('enrollments.index') }}" class="filters" style="grid-template-columns: 1fr 180px; margin-top: 16px;">
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
        <th>Hoc vien</th>
        <th>Email</th>
        <th>Ngay dang ky</th>
        <th>Thao tac</th>
    </tr>
    </thead>
    <tbody>
    @forelse($enrollments as $enrollment)
        <tr>
            <td>{{ $enrollment->course->name }}</td>
            <td>{{ $enrollment->student->name }}</td>
            <td>{{ $enrollment->student->email }}</td>
            <td>{{ $enrollment->created_at?->format('d/m/Y H:i') }}</td>
            <td>
                <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" onsubmit="return confirm('Huy dang ky nay?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" type="submit">Huy</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="subtitle">Chua co dang ky.</td></tr>
    @endforelse
    </tbody>
</x-table>

<div class="pagination">{{ $enrollments->links() }}</div>
@endsection

@extends('layouts.app')

@section('title', 'Thung rac khoa hoc')

@section('content')
<div class="header">
    <div>
        <h1>Thung rac khoa hoc</h1>
        <p class="subtitle">Khoi phuc cac khoa hoc da soft delete</p>
    </div>
    <a class="btn btn-outline" href="{{ route('courses.index') }}">Ve danh sach</a>
</div>

<x-table>
    <thead>
    <tr>
        <th>Ten</th>
        <th>Gia</th>
        <th>Trang thai</th>
        <th>Bai hoc</th>
        <th>Ngay xoa</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($courses as $course)
        <tr>
            <td>{{ $course->name }}</td>
            <td>{{ number_format($course->price, 0, ',', '.') }} VND</td>
            <td><x-badge-status :status="$course->status" /></td>
            <td>{{ $course->lessons_count }}</td>
            <td>{{ $course->deleted_at?->format('d/m/Y H:i') }}</td>
            <td>
                <form action="{{ route('courses.restore', $course->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-sm" type="submit">Khoi phuc</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="subtitle">Khong co khoa hoc da xoa.</td></tr>
    @endforelse
    </tbody>
</x-table>

<div class="pagination">{{ $courses->links() }}</div>
@endsection

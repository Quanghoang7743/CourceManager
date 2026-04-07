@extends('layouts.app')
@section('title', 'Danh sách sinh viên')
@section('content')
<div class="header">
    <div>
        <h1>Danh sách sinh viên</h1>
        <p class="subtitle">Quản lý sinh viên và xem tổng tín chỉ đã đăng ký</p>
    </div>
    <a class="btn" href="/students/create">Thêm sinh viên</a>
</div>
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>MSSV</th>
                <th>Họ tên</th>
                <th>Số môn</th>
                <th>Tổng tín chỉ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
            <tr>
                <td>{{ $student->student_code }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->courses_count }}</td>
                <td>
                    @php $credits = $student->courses_sum_credits ?? 0; @endphp
                    <span class="badge {{ $credits >= 18 ? 'badge-warn' : '' }}">{{ $credits }} / 18</span>
                </td>
                <td>
                    <form action="/students/{{ $student->id }}" method="POST" onsubmit="return confirm('Xóa sinh viên này?')" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td class="empty" colspan="5">Chưa có sinh viên nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

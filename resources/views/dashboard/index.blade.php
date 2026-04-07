@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="header">
    <div>
        <h1>Dashboard</h1>
        <p class="subtitle">Tong quan khoa hoc, hoc vien va doanh thu</p>
    </div>
</div>

<div class="grid-4">
    <div class="stat"><p>Tong khoa hoc</p><strong>{{ $totalCourses }}</strong></div>
    <div class="stat"><p>Tong hoc vien</p><strong>{{ $totalStudents }}</strong></div>
    <div class="stat"><p>Tong doanh thu</p><strong>{{ number_format($totalRevenue, 0, ',', '.') }} VND</strong></div>
    <div class="stat"><p>Khoa hoc noi bat</p><strong>{{ $topCourse?->name ?? 'Chua co' }}</strong></div>
</div>

<h2>5 khoa hoc moi</h2>
<div class="cards">
    @forelse($latestCourses as $course)
        <x-card-course :course="$course" />
    @empty
        <p class="subtitle">Chua co khoa hoc moi.</p>
    @endforelse
</div>
@endsection

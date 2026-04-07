<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Learning Admin')</title>
    <style>
        :root {
            --bg: #f5f7fb;
            --surface: #ffffff;
            --sidebar: #0f172a;
            --text: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --primary: #0ea5a4;
            --primary-dark: #0b8b8a;
            --danger: #dc2626;
            --success-bg: #dcfce7;
            --success-text: #166534;
            --error-bg: #fee2e2;
            --error-text: #991b1b;
            --draft-bg: #fef3c7;
            --draft-text: #92400e;
            --published-bg: #d1fae5;
            --published-text: #065f46;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: radial-gradient(circle at 5% 5%, #dbeafe 0, transparent 38%), var(--bg);
            color: var(--text);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .app {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, #0f172a 0%, #111827 100%);
            color: #e2e8f0;
            padding: 28px 16px;
        }

        .brand {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 24px;
            letter-spacing: 0.03em;
        }

        .menu a {
            display: block;
            padding: 11px 12px;
            margin-bottom: 8px;
            border-radius: 10px;
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(14, 165, 164, 0.22);
            color: #f8fafc;
        }

        .content {
            padding: 24px;
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        h1 { font-size: 1.5rem; }
        h2 { font-size: 1rem; margin-bottom: 10px; }
        .subtitle { color: var(--muted); margin-top: 4px; font-size: 0.92rem; }

        .btn {
            border: 0;
            border-radius: 10px;
            padding: 10px 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            color: #fff;
            background: var(--primary);
        }

        .btn:hover { background: var(--primary-dark); }
        .btn-sm { padding: 7px 10px; font-size: 0.86rem; }
        .btn-danger { background: var(--danger); }
        .btn-outline { background: transparent; border: 1px solid var(--line); color: var(--text); }

        .alert { padding: 11px 14px; border-radius: 10px; margin-bottom: 14px; }
        .alert-success { background: var(--success-bg); color: var(--success-text); }
        .alert-error { background: var(--error-bg); color: var(--error-text); }

        .filters {
            display: grid;
            grid-template-columns: repeat(5, minmax(120px, 1fr));
            gap: 10px;
            margin-bottom: 16px;
        }

        .field { margin-bottom: 14px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.92rem; }

        input, select, textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 10px 12px;
            font: inherit;
            background: #fff;
        }

        textarea { resize: vertical; }
        .error-text { margin-top: 5px; color: var(--danger); font-size: 0.84rem; }

        .table-wrap { overflow: auto; border: 1px solid var(--line); border-radius: 12px; }
        table { width: 100%; border-collapse: collapse; min-width: 700px; }
        th, td { text-align: left; padding: 10px 12px; border-bottom: 1px solid var(--line); }
        th { background: #f8fafc; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.04em; }

        .badge {
            display: inline-block;
            border-radius: 999px;
            padding: 3px 10px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .badge-draft { background: var(--draft-bg); color: var(--draft-text); }
        .badge-published { background: var(--published-bg); color: var(--published-text); }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, minmax(160px, 1fr));
            gap: 12px;
            margin-bottom: 18px;
        }

        .stat {
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 14px;
            background: #fff;
        }

        .stat p { color: var(--muted); font-size: 0.85rem; }
        .stat strong { font-size: 1.2rem; display: block; margin-top: 4px; }

        .course-card {
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
        }

        .course-thumb-wrap { height: 120px; background: #f1f5f9; }
        .course-thumb { width: 100%; height: 100%; object-fit: cover; display: block; }
        .course-thumb.placeholder { display: flex; align-items: center; justify-content: center; color: var(--muted); }
        .course-body { padding: 12px; }
        .course-head { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 8px; }
        .course-sub { color: var(--muted); font-size: 0.88rem; margin-bottom: 4px; }

        .cards { display: grid; grid-template-columns: repeat(3, minmax(180px, 1fr)); gap: 12px; margin-top: 14px; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .pagination { margin-top: 14px; }

        @media (max-width: 960px) {
            .app { grid-template-columns: 1fr; }
            .sidebar { padding: 16px; }
            .content { padding: 16px; }
            .filters { grid-template-columns: 1fr 1fr; }
            .grid-4 { grid-template-columns: 1fr 1fr; }
            .cards { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand">Learning Admin</div>
        <nav class="menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Trang chu</a>
            <a href="{{ route('courses.index') }}" class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">Khoa hoc</a>
            <a href="{{ route('lessons.index') }}" class="{{ request()->routeIs('lessons.*') ? 'active' : '' }}">Bai giang</a>
            <a href="{{ route('enrollments.index') }}" class="{{ request()->routeIs('enrollments.*') ? 'active' : '' }}">Dang ky hoc vien</a>
        </nav>
    </aside>

    <main class="content">
        <section class="panel">
            @if (session('success'))
                <x-alert type="success">{{ session('success') }}</x-alert>
            @endif

            @if (session('error'))
                <x-alert type="error">{{ session('error') }}</x-alert>
            @endif

            @yield('content')
        </section>
    </main>
</div>
</body>
</html>

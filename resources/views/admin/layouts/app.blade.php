<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Admin Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; display: flex; min-height: 100vh; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 240px; flex-shrink: 0;
            background: #0a0c10;
            border-right: 1px solid #1a2035;
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; height: 100vh;
            overflow-y: auto;
        }
        .sidebar-logo {
            padding: 24px 20px;
            border-bottom: 1px solid #1a2035;
        }
        .sidebar-logo .mark {
            display: inline-flex; align-items: center; justify-content: center;
            width: 36px; height: 36px;
            background: rgba(56,189,248,0.1);
            border: 1px solid rgba(56,189,248,0.25);
            border-radius: 8px;
            font-size: 13px; font-weight: 600; color: #38bdf8;
            margin-bottom: 10px;
        }
        .sidebar-logo .site-name { font-size: 13px; font-weight: 600; color: #f1f5f9; }
        .sidebar-logo .sub { font-size: 11px; color: #475569; margin-top: 2px; }

        .nav-section { padding: 16px 12px 8px; }
        .nav-label { font-size: 10px; color: #334155; text-transform: uppercase; letter-spacing: 0.1em; padding: 0 8px; margin-bottom: 6px; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px; border-radius: 8px;
            font-size: 13px; color: #64748b;
            text-decoration: none; margin-bottom: 2px;
            transition: all 0.15s;
        }
        .nav-item i { font-size: 17px; }
        .nav-item:hover { background: #0f1520; color: #cbd5e1; }
        .nav-item.active { background: rgba(56,189,248,0.1); color: #38bdf8; }
        .nav-item .badge {
            margin-left: auto; background: #ef4444;
            color: #fff; font-size: 10px; font-weight: 600;
            padding: 1px 6px; border-radius: 10px;
        }

        .sidebar-footer {
            margin-top: auto; padding: 16px 12px;
            border-top: 1px solid #1a2035;
        }
        .admin-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .admin-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: rgba(56,189,248,0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 600; color: #38bdf8;
        }
        .admin-name { font-size: 12px; color: #94a3b8; font-weight: 500; }
        .admin-role { font-size: 10px; color: #334155; }
        .logout-btn {
            display: flex; align-items: center; gap: 8px;
            width: 100%; padding: 8px 10px; border-radius: 8px;
            background: none; border: 1px solid #1a2035;
            color: #475569; font-size: 12px; font-family: inherit;
            cursor: pointer; transition: all 0.15s;
        }
        .logout-btn:hover { background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.3); color: #fca5a5; }

        /* ── MAIN ── */
        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        .topbar {
            background: #fff; border-bottom: 1px solid #e2e8f0;
            padding: 16px 28px; display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 10;
        }
        .topbar-title { font-size: 16px; font-weight: 600; color: #0f172a; }
        .topbar-sub   { font-size: 12px; color: #94a3b8; margin-top: 1px; }
        .topbar-actions { display: flex; gap: 10px; align-items: center; }
        .btn-view {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: 8px;
            background: #0a0c10; color: #38bdf8;
            font-size: 12px; font-weight: 500; text-decoration: none;
            border: 1px solid #1a2035;
        }

        .content { padding: 28px; flex: 1; }

        /* ── ALERTS ── */
        .alert-success {
            background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.25);
            color: #86efac; border-radius: 8px; padding: 12px 16px;
            font-size: 13px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }
        .alert-error {
            background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.25);
            color: #fca5a5; border-radius: 8px; padding: 12px 16px;
            font-size: 13px; margin-bottom: 20px;
        }

        /* ── CARDS ── */
        .card {
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 12px; padding: 24px;
        }
        .card-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px; padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        .card-title { font-size: 14px; font-weight: 600; color: #0f172a; }

        /* ── FORM ELEMENTS ── */
        .form-group { margin-bottom: 18px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-label { display: block; font-size: 12px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-label .required { color: #ef4444; }
        .form-input, .form-select, .form-textarea {
            width: 100%; background: #f8fafc; border: 1px solid #e2e8f0;
            border-radius: 8px; padding: 9px 12px;
            font-size: 13px; color: #1e293b; font-family: inherit;
            transition: border-color 0.2s; outline: none;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: #38bdf8; background: #fff; }
        .form-textarea { resize: vertical; min-height: 100px; }
        .form-hint { font-size: 11px; color: #94a3b8; margin-top: 4px; }
        .form-error { font-size: 11px; color: #ef4444; margin-top: 4px; }

        /* ── TABLE ── */
        .table { width: 100%; border-collapse: collapse; }
        .table th {
            text-align: left; font-size: 11px; font-weight: 500;
            color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;
            padding: 10px 14px; border-bottom: 1px solid #f1f5f9;
        }
        .table td { padding: 12px 14px; font-size: 13px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover td { background: #f8fafc; }

        /* ── BUTTONS ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; border-radius: 8px;
            background: #38bdf8; color: #0a0c10;
            font-size: 13px; font-weight: 500; font-family: inherit;
            border: none; cursor: pointer; text-decoration: none;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: #0ea5e9; }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; border-radius: 8px;
            background: #fff; color: #374151;
            font-size: 13px; font-weight: 500; font-family: inherit;
            border: 1px solid #e2e8f0; cursor: pointer; text-decoration: none;
        }
        .btn-secondary:hover { background: #f8fafc; }
        .btn-danger {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: 8px;
            background: rgba(239,68,68,0.08); color: #ef4444;
            font-size: 12px; font-weight: 500; font-family: inherit;
            border: 1px solid rgba(239,68,68,0.2); cursor: pointer; text-decoration: none;
        }
        .btn-danger:hover { background: rgba(239,68,68,0.15); }
        .btn-sm { padding: 5px 12px; font-size: 12px; }

        /* ── BADGE ── */
        .tag {
            display: inline-block; padding: 2px 10px; border-radius: 12px;
            font-size: 11px; font-weight: 500;
        }
        .tag-blue { background: rgba(56,189,248,0.1); color: #0ea5e9; }
        .tag-green { background: rgba(34,197,94,0.1); color: #16a34a; }
        .tag-gray { background: #f1f5f9; color: #64748b; }
        .tag-red { background: rgba(239,68,68,0.1); color: #dc2626; }

        /* ── STAT CARDS ── */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
            padding: 20px; display: flex; align-items: flex-start; gap: 14px;
        }
        .stat-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .stat-icon.blue { background: rgba(56,189,248,0.1); color: #38bdf8; }
        .stat-icon.green { background: rgba(34,197,94,0.1); color: #22c55e; }
        .stat-icon.purple { background: rgba(168,85,247,0.1); color: #a855f7; }
        .stat-icon.orange { background: rgba(249,115,22,0.1); color: #f97316; }
        .stat-num { font-size: 24px; font-weight: 600; color: #0f172a; line-height: 1; }
        .stat-label { font-size: 12px; color: #94a3b8; margin-top: 4px; }

        /* ── COLOR PICKER ── */
        .color-input-wrap { display: flex; align-items: center; gap: 10px; }
        .color-input-wrap input[type="color"] { width: 40px; height: 36px; border-radius: 6px; border: 1px solid #e2e8f0; cursor: pointer; padding: 2px; }

        /* ── FILE UPLOAD ── */
        .file-upload {
            border: 2px dashed #e2e8f0; border-radius: 10px;
            padding: 20px; text-align: center; cursor: pointer;
            transition: border-color 0.2s;
        }
        .file-upload:hover { border-color: #38bdf8; }
        .file-upload input { display: none; }
        .file-upload i { font-size: 28px; color: #94a3b8; }
        .file-upload p { font-size: 12px; color: #94a3b8; margin-top: 6px; }
        .file-upload .filename { font-size: 12px; color: #38bdf8; margin-top: 4px; }

        /* ── PREVIEW ── */
        .img-preview { width: 80px; height: 80px; border-radius: 8px; object-fit: cover; border: 1px solid #e2e8f0; }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="mark">TT</div>
        <div class="site-name">Tim Tom</div>
        <div class="sub">Portfolio Admin</div>
    </div>

    <div class="nav-section">
        <div class="nav-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="ti ti-dashboard"></i> Dashboard
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-label">Content</div>
        <a href="{{ route('admin.settings.edit') }}" class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
            <i class="ti ti-settings"></i> Settings
        </a>
        <a href="{{ route('admin.hero.edit') }}" class="nav-item {{ request()->routeIs('admin.hero*') ? 'active' : '' }}">
            <i class="ti ti-home"></i> Hero Section
        </a>
        <a href="{{ route('admin.skills.index') }}" class="nav-item {{ request()->routeIs('admin.skills*') ? 'active' : '' }}">
            <i class="ti ti-code"></i> Skills
        </a>
        <a href="{{ route('admin.experiences.index') }}" class="nav-item {{ request()->routeIs('admin.experiences*') ? 'active' : '' }}">
            <i class="ti ti-briefcase"></i> Experience
        </a>
        <a href="{{ route('admin.certifications.index') }}" class="nav-item {{ request()->routeIs('admin.certifications*') ? 'active' : '' }}">
            <i class="ti ti-certificate"></i> Certifications
        </a>
        <a href="{{ route('admin.projects.index') }}" class="nav-item {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
            <i class="ti ti-layout-grid"></i> Projects
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-label">Inbox</div>
        <a href="{{ route('admin.messages.index') }}" class="nav-item {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
            <i class="ti ti-mail"></i> Messages
            @php $unread = \App\Models\ContactMessage::unread()->count(); @endphp
            @if($unread > 0)
                <span class="badge">{{ $unread }}</span>
            @endif
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="admin-info">
            <div class="admin-avatar">{{ substr(Auth::guard('admin')->user()->name, 0, 2) }}</div>
            <div>
                <div class="admin-name">{{ Auth::guard('admin')->user()->name }}</div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="ti ti-logout"></i> Sign Out
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="main">
    <div class="topbar">
        <div>
            <div class="topbar-title">@yield('title', 'Dashboard')</div>
            <div class="topbar-sub">@yield('subtitle', 'Manage your portfolio content')</div>
        </div>
        <div class="topbar-actions">
            <a href="{{ route('portfolio') }}" target="_blank" class="btn-view">
                <i class="ti ti-external-link"></i> View Portfolio
            </a>
            @yield('topbar-actions')
        </div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert-success">
                <i class="ti ti-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-error">
                <i class="ti ti-alert-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
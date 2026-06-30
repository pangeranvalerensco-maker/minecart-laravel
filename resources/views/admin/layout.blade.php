<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superadmin Dashboard - MineCart</title>
    <style>
        :root {
            --bg-dark: #0f172a;
            --bg-panel: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --success: #10b981;
            --danger: #ef4444;
            --border: #334155;
        }
        body {
            margin: 0;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background-color: var(--bg-panel);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            padding: 20px;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid var(--border);
            text-align: center;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li a {
            display: block;
            padding: 15px 20px;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background-color: var(--bg-dark);
            color: var(--primary);
            border-left: 4px solid var(--primary);
        }
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }
        .card {
            background-color: var(--bg-panel);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--border);
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .stat-card {
            background: linear-gradient(145deg, var(--bg-panel), #233045);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--border);
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .stat-card h3 {
            margin: 0;
            color: var(--text-muted);
            font-size: 1rem;
        }
        .stat-card .value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary);
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        th {
            color: var(--text-muted);
        }
        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            color: white;
            font-weight: 500;
        }
        .btn-primary { background-color: var(--primary); }
        .btn-primary:hover { background-color: var(--primary-hover); }
        .btn-success { background-color: var(--success); }
        .btn-danger { background-color: var(--danger); }
        .badge {
            padding: 4px 8px;
            border-radius: 99px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .badge-active { background-color: rgba(16, 185, 129, 0.2); color: var(--success); }
        .badge-blocked { background-color: rgba(239, 68, 68, 0.2); color: var(--danger); }
        
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            background-color: var(--bg-dark);
            border: 1px solid var(--border);
            color: var(--text-main);
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">MineCart Admin</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.users.index') }}">Users Management</a></li>
            <li><a href="{{ route('admin.withdrawals.index') }}">Withdrawals</a></li>
            <li><a href="{{ route('admin.settings.index') }}">Settings</a></li>
            <li><a href="{{ route('home') }}">Back to Site</a></li>
        </ul>
    </div>
    <div class="main-content">
        @if(session('success'))
            <div class="card" style="border-color: var(--success); color: var(--success);">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="card" style="border-color: var(--danger); color: var(--danger);">
                {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </div>
</body>
</html>

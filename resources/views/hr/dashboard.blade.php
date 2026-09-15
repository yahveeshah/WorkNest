<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>HR Dashboard | WorkNest</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box }
        body { margin: 0; background: #4A1F50; color: #F2E5D5; font-family: 'DM Sans', sans-serif }
        .layout { display: grid; grid-template-columns: 280px 1fr; min-height: 100vh }
        .sidebar { background: #341539; border-right: 1px solid rgba(209, 176, 193, .1); padding: 2.5rem 1.8rem; display: flex; flex-direction: column }
        .nav { margin: 3rem 0; padding: 0; list-style: none }
        .nav a { display: block; padding: .75rem 1rem; border-left: 3px solid transparent; color: #D1B0C1; text-decoration: none; font-size: .9rem }
        .nav a.active, .nav a:hover { border-left-color: #F6EB61; background: rgba(246, 235, 97, .04); color: #F6EB61 }
        .logout { width: 100%; margin-top: auto; border: 0; border-radius: 50px; background: #F6EB61; color: #000; padding: .65rem; font: 600 .9rem 'DM Sans', sans-serif; cursor: pointer }
        .main { padding: 3rem 4rem }
        .header { padding-bottom: 1.5rem; margin-bottom: 2.5rem; border-bottom: 1px solid rgba(209, 176, 193, .08) }
        .badge { display: inline-block; padding: .25rem .75rem; border-radius: 4px; background: rgba(246, 235, 97, .1); color: #F6EB61; font-size: .8rem; letter-spacing: 1px }
        .header h1 { margin: .7rem 0 .3rem; font: 700 2.6rem 'Cormorant Garamond', serif }
        .header p { margin: 0; color: #D1B0C1 }

        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem }
        .stat-card { padding: 1.8rem; border: 1px solid rgba(209, 176, 193, .1); border-radius: 14px; background: #341539 }
        .stat-card h3 { margin: 0 0 .5rem; font-size: .85rem; color: #D1B0C1; text-transform: uppercase; letter-spacing: .8px }
        .stat-card .number { font: 700 2.5rem 'Cormorant Garamond', serif; color: #F6EB61; margin-bottom: 1rem }
        
        .btn-yellow { border: 0; border-radius: 50px; background: #F6EB61; color: #341539; padding: .6rem 1.4rem; font: 600 .85rem 'DM Sans', sans-serif; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center }
        .btn-yellow:hover { background: #e5da50 }

        .card { max-width: 900px; padding: 2rem; border: 1px solid rgba(209, 176, 193, .1); border-radius: 14px; background: #341539 }
        .card h2 { margin: 0 0 .8rem; color: #F6EB61; font: 600 1.6rem 'Cormorant Garamond', serif }
        .card p { margin: 0; color: #D1B0C1; line-height: 1.7 }

        @media (max-width: 850px) {
            .layout { grid-template-columns: 1fr }
            .sidebar { min-height: auto; padding: 1.5rem }
            .main { padding: 2rem 1.5rem }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        @include('partials.logo', ['height' => 40])
        <ul class="nav">
            <li><a href="{{ route('hr.dashboard') }}" class="active">Overview</a></li>
            <li><a href="{{ route('hr.employees.index') }}">Employee Directory</a></li>
            <li><a href="{{ route('hr.departments.index') }}">Departments</a></li>
        </ul>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout">Logout</button>
        </form>
    </aside>
    <main class="main">
        <header class="header">
            <span class="badge">{{ $organization->name }}</span>
            <h1>People Operations Dashboard</h1>
            <p>Review organization headcount, department breakdowns, and manage employee records.</p>
        </header>

        <div class="grid">
            <div class="stat-card">
                <h3>Total Employees</h3>
                <div class="number">{{ $totalEmployees ?? 0 }}</div>
                <a href="{{ route('hr.employees.index') }}" class="btn-yellow">View Employee Directory</a>
            </div>
            <div class="stat-card">
                <h3>Active Employees</h3>
                <div class="number">{{ $activeEmployees ?? 0 }}</div>
                <a href="{{ route('hr.employees.index', ['status' => 'active']) }}" class="btn-yellow">Filter Active</a>
            </div>
            <div class="stat-card">
                <h3>Departments</h3>
                <div class="number">{{ $departmentsCount ?? 0 }}</div>
                <a href="{{ route('hr.departments.index') }}" class="btn-yellow">Manage Departments</a>
            </div>
        </div>

        <section class="card">
            <h2>HR Records Foundation</h2>
            <p>Use the navigation menu or action cards above to manage department structure, assign employees to departments, update positions, and manage active/inactive statuses for all members of {{ $organization->name }}.</p>
        </section>
    </main>
</div>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Employee Directory | WorkNest</title>
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
        
        .card { max-width: 1100px; padding: 2rem; border: 1px solid rgba(209, 176, 193, .1); border-radius: 14px; background: #341539; margin-bottom: 2rem }
        .card h2 { margin: 0 0 .8rem; color: #F6EB61; font: 600 1.6rem 'Cormorant Garamond', serif }
        
        .alert-success { background: rgba(163, 190, 140, .15); border: 1px solid #A3BE8C; color: #A3BE8C; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem }
        
        .filters { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 1rem; margin-bottom: 1.5rem; align-items: flex-end }
        .form-control { display: flex; flex-direction: column; gap: .4rem }
        .form-control label { font-size: .8rem; color: #D1B0C1; font-weight: 500 }
        .input-text, .input-select { background: rgba(255, 255, 255, .05); border: 1px solid rgba(209, 176, 193, .2); border-radius: 8px; padding: .6rem .8rem; color: #FFF0C4; font-family: 'DM Sans', sans-serif; font-size: .85rem }
        .input-select option { background: #341539; color: #FFF0C4 }
        .input-text:focus, .input-select:focus { outline: none; border-color: #F6EB61 }
        
        .btn-yellow { border: 0; border-radius: 50px; background: #F6EB61; color: #341539; padding: .65rem 1.4rem; font: 600 .85rem 'DM Sans', sans-serif; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center }
        .btn-yellow:hover { background: #e5da50 }
        .btn-outline-secondary { background: transparent; border: 1px solid rgba(209, 176, 193, .3); color: #D1B0C1; border-radius: 50px; padding: .6rem 1rem; font-size: .85rem; text-decoration: none; display: inline-flex; align-items: center }
        .btn-outline-secondary:hover { border-color: #FFF0C4; color: #FFF0C4 }
        .btn-sm { padding: .35rem .8rem; font-size: .8rem }

        .table { width: 100%; border-collapse: collapse; margin-top: .5rem }
        .table th, .table td { padding: 1rem .8rem; text-align: left; border-bottom: 1px solid rgba(209, 176, 193, .1) }
        .table th { color: #D1B0C1; font-size: .75rem; letter-spacing: .8px; text-transform: uppercase }
        .table td { font-size: .88rem }
        .table tr:hover { background: rgba(255, 255, 255, .02) }

        .badge-active { background: rgba(163, 190, 140, .2); color: #A3BE8C; border: 1px solid rgba(163, 190, 140, .3); padding: .2rem .6rem; border-radius: 50px; font-size: .75rem; text-transform: capitalize }
        .badge-inactive { background: rgba(192, 97, 106, .2); color: #C0616A; border: 1px solid rgba(192, 97, 106, .3); padding: .2rem .6rem; border-radius: 50px; font-size: .75rem; text-transform: capitalize }
        .role-badge { background: rgba(246, 235, 97, .1); color: #F6EB61; border: 1px solid rgba(246, 235, 97, .2); padding: .2rem .6rem; border-radius: 4px; font-size: .75rem; text-transform: uppercase }

        .pagination { display: flex; gap: .5rem; margin-top: 1.5rem; justify-content: flex-end }
        .pagination a, .pagination span { padding: .4rem .8rem; border-radius: 6px; background: rgba(255, 255, 255, .05); color: #D1B0C1; text-decoration: none; font-size: .85rem }
        .pagination span.active { background: #F6EB61; color: #341539; font-weight: 600 }

        @media (max-width: 950px) {
            .layout { grid-template-columns: 1fr }
            .sidebar { min-height: auto; padding: 1.5rem }
            .main { padding: 2rem 1.5rem }
            .filters { grid-template-columns: 1fr 1fr }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        @include('partials.logo', ['height' => 40])
        <ul class="nav">
            <li><a href="{{ route(strtolower($currentUser->role) === 'admin' ? 'admin.dashboard' : 'hr.dashboard') }}">Overview</a></li>
            <li><a href="{{ route('hr.employees.index') }}" class="active">Employee Directory</a></li>
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
            <h1>Employee Directory</h1>
            <p>Manage employee records, positions, department assignments, and access statuses.</p>
        </header>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <section class="card">
            <h2>Search & Filter Directory</h2>
            <form action="{{ route('hr.employees.index') }}" method="GET" class="filters">
                <div class="form-control">
                    <label for="search">Search Name or Email</label>
                    <input type="text" id="search" name="search" class="input-text" placeholder="e.g. John Doe" value="{{ request('search') }}">
                </div>
                <div class="form-control">
                    <label for="department_id">Department</label>
                    <select id="department_id" name="department_id" class="input-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ (string)request('department_id') === (string)$dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="input-select">
                        <option value="">All Roles</option>
                        @foreach($roles as $r)
                            <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>
                                {{ ucfirst($r) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="input-select">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div style="display: flex; gap: .5rem">
                    <button type="submit" class="btn-yellow">Filter</button>
                    @if(request()->hasAny(['search', 'department_id', 'role', 'status']))
                        <a href="{{ route('hr.employees.index') }}" class="btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>

            @if($employees->isEmpty())
                <p style="margin-top: 1.5rem;">No employees found matching the criteria.</p>
            @else
                <div style="overflow-x: auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Department</th>
                                <th>Position</th>
                                <th>Date Joined</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $emp)
                                <tr>
                                    <td><strong>{{ $emp->name }}</strong></td>
                                    <td>{{ $emp->email }}</td>
                                    <td><span class="role-badge">{{ $emp->role }}</span></td>
                                    <td>{{ $emp->departmentRecord?->name ?? $emp->department ?? '-' }}</td>
                                    <td>{{ $emp->position ?? '-' }}</td>
                                    <td>{{ $emp->date_joined ? $emp->date_joined->format('M d, Y') : '-' }}</td>
                                    <td>
                                        <span class="badge-{{ $emp->status ?? 'active' }}">
                                            {{ $emp->status ?? 'active' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('hr.employees.edit', $emp) }}" class="btn-yellow btn-sm">Edit Profile</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($employees->hasPages())
                    <div class="pagination">
                        {{ $employees->links() }}
                    </div>
                @endif
            @endif
        </section>
    </main>
</div>
</body>
</html>

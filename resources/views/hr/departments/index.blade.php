<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Department Management | WorkNest</title>
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
        
        .card { max-width: 1000px; padding: 2rem; border: 1px solid rgba(209, 176, 193, .1); border-radius: 14px; background: #341539; margin-bottom: 2rem }
        .card h2 { margin: 0 0 .8rem; color: #F6EB61; font: 600 1.6rem 'Cormorant Garamond', serif }
        .card p { margin: 0 0 1.5rem; color: #D1B0C1; line-height: 1.7 }
        
        .alert-success { background: rgba(163, 190, 140, .15); border: 1px solid #A3BE8C; color: #A3BE8C; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem }
        .alert-error { background: rgba(192, 97, 106, .15); border: 1px solid #C0616A; color: #F28B82; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem }

        .form-group { display: flex; gap: 1rem; align-items: flex-end; margin-bottom: 1rem }
        .form-control { display: flex; flex-direction: column; gap: .4rem; flex: 1 }
        .form-control label { font-size: .85rem; color: #D1B0C1; font-weight: 500 }
        .input-text { background: rgba(255, 255, 255, .05); border: 1px solid rgba(209, 176, 193, .2); border-radius: 8px; padding: .65rem 1rem; color: #FFF0C4; font-family: 'DM Sans', sans-serif; font-size: .9rem }
        .input-text:focus { outline: none; border-color: #F6EB61 }
        
        .btn-yellow { border: 0; border-radius: 50px; background: #F6EB61; color: #341539; padding: .65rem 1.5rem; font: 600 .9rem 'DM Sans', sans-serif; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: .5rem }
        .btn-yellow:hover { background: #e5da50 }
        
        .btn-sm { padding: .4rem .9rem; font-size: .8rem }
        .btn-outline-danger { background: transparent; border: 1px solid #C0616A; color: #C0616A; border-radius: 50px; cursor: pointer }
        .btn-outline-danger:hover { background: #C0616A; color: #000 }
        .btn-outline-secondary { background: transparent; border: 1px solid rgba(209, 176, 193, .3); color: #D1B0C1; border-radius: 50px; cursor: pointer; text-decoration: none }
        .btn-outline-secondary:hover { border-color: #FFF0C4; color: #FFF0C4 }

        .table { width: 100%; border-collapse: collapse; margin-top: 1rem }
        .table th, .table td { padding: 1rem; text-align: left; border-bottom: 1px solid rgba(209, 176, 193, .1) }
        .table th { color: #D1B0C1; font-size: .78rem; letter-spacing: .8px; text-transform: uppercase }
        .table td { font-size: .9rem }

        .inline-edit-form { display: flex; gap: .5rem; align-items: center }
        .inline-edit-form input { padding: .35rem .6rem; font-size: .85rem }

        @media (max-width: 850px) {
            .layout { grid-template-columns: 1fr }
            .sidebar { min-height: auto; padding: 1.5rem }
            .main { padding: 2rem 1.5rem }
            .form-group { flex-direction: column; align-items: stretch }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        @include('partials.logo', ['height' => 40])
        <ul class="nav">
            <li><a href="{{ route(strtolower($user->role) === 'admin' ? 'admin.dashboard' : 'hr.dashboard') }}">Overview</a></li>
            <li><a href="{{ route('hr.employees.index') }}">Employee Directory</a></li>
            <li><a href="{{ route('hr.departments.index') }}" class="active">Departments</a></li>
        </ul>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout">Logout</button>
        </form>
    </aside>
    <main class="main">
        <header class="header">
            <span class="badge">{{ $organization->name }}</span>
            <h1>Department Management</h1>
            <p>Create and manage organizational departments for {{ $organization->name }}.</p>
        </header>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                <strong>Warning:</strong> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 1.2rem">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Create Department Form -->
        <section class="card">
            <h2>Add New Department</h2>
            <form action="{{ route('hr.departments.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="form-control">
                        <label for="name">Department Name</label>
                        <input type="text" id="name" name="name" class="input-text" placeholder="e.g. Engineering, Human Resources, Finance" value="{{ old('name') }}" required>
                    </div>
                    <button type="submit" class="btn-yellow">Create Department</button>
                </div>
            </form>
        </section>

        <!-- Department List -->
        <section class="card">
            <h2>Organization Departments ({{ $departments->count() }})</h2>
            @if($departments->isEmpty())
                <p>No departments have been added to this organization yet.</p>
            @else
                <div style="overflow-x: auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Department Name</th>
                                <th>Assigned Employees</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $dept)
                                <tr>
                                    <td>
                                        <div id="view-name-{{ $dept->id }}">
                                            <strong>{{ $dept->name }}</strong>
                                        </div>
                                        <form id="edit-form-{{ $dept->id }}" action="{{ route('hr.departments.update', $dept) }}" method="POST" class="inline-edit-form" style="display: none;">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="name" value="{{ $dept->name }}" class="input-text" required>
                                            <button type="submit" class="btn-yellow btn-sm">Save</button>
                                            <button type="button" class="btn-outline-secondary btn-sm" onclick="cancelEdit({{ $dept->id }})">Cancel</button>
                                        </form>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: rgba(209, 176, 193, .15); color: #FFF0C4;">
                                            {{ $dept->users_count }} {{ Str::plural('employee', $dept->users_count) }}
                                        </span>
                                    </td>
                                    <td>{{ $dept->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div id="actions-{{ $dept->id }}" style="display: flex; gap: .5rem">
                                            <button type="button" class="btn-outline-secondary btn-sm" onclick="enableEdit({{ $dept->id }})">Edit</button>
                                            <form action="{{ route('hr.departments.destroy', $dept) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the {{ $dept->name }} department?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-outline-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </main>
</div>

<script>
    function enableEdit(id) {
        document.getElementById('view-name-' + id).style.display = 'none';
        document.getElementById('actions-' + id).style.display = 'none';
        document.getElementById('edit-form-' + id).style.display = 'flex';
    }

    function cancelEdit(id) {
        document.getElementById('view-name-' + id).style.display = 'block';
        document.getElementById('actions-' + id).style.display = 'flex';
        document.getElementById('edit-form-' + id).style.display = 'none';
    }
</script>
</body>
</html>

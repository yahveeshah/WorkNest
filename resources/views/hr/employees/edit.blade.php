<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Edit Employee Profile | WorkNest</title>
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
        
        .card { max-width: 800px; padding: 2rem; border: 1px solid rgba(209, 176, 193, .1); border-radius: 14px; background: #341539; margin-bottom: 2rem }
        .card h2 { margin: 0 0 .8rem; color: #F6EB61; font: 600 1.6rem 'Cormorant Garamond', serif }
        
        .alert-error { background: rgba(192, 97, 106, .15); border: 1px solid #C0616A; color: #F28B82; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem }
        .form-group-full { grid-column: 1 / -1 }
        .form-control { display: flex; flex-direction: column; gap: .4rem }
        .form-control label { font-size: .85rem; color: #D1B0C1; font-weight: 500 }
        .input-text, .input-select { background: rgba(255, 255, 255, .05); border: 1px solid rgba(209, 176, 193, .2); border-radius: 8px; padding: .7rem 1rem; color: #FFF0C4; font-family: 'DM Sans', sans-serif; font-size: .9rem }
        .input-select option { background: #341539; color: #FFF0C4 }
        .input-text:disabled { opacity: .6; cursor: not-allowed }
        .input-text:focus, .input-select:focus { outline: none; border-color: #F6EB61 }
        
        .actions { display: flex; gap: 1rem; align-items: center; margin-top: 1rem }
        .btn-yellow { border: 0; border-radius: 50px; background: #F6EB61; color: #341539; padding: .7rem 1.8rem; font: 600 .9rem 'DM Sans', sans-serif; cursor: pointer; text-decoration: none }
        .btn-yellow:hover { background: #e5da50 }
        .btn-outline-secondary { background: transparent; border: 1px solid rgba(209, 176, 193, .3); color: #D1B0C1; border-radius: 50px; padding: .7rem 1.5rem; font-size: .9rem; text-decoration: none }
        .btn-outline-secondary:hover { border-color: #FFF0C4; color: #FFF0C4 }

        @media (max-width: 850px) {
            .layout { grid-template-columns: 1fr }
            .sidebar { min-height: auto; padding: 1.5rem }
            .main { padding: 2rem 1.5rem }
            .form-grid { grid-template-columns: 1fr }
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
            <span class="badge">Edit Profile</span>
            <h1>{{ $employee->name }}</h1>
            <p>{{ $employee->email }} &bull; Role: {{ ucfirst($employee->role) }}</p>
        </header>

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 1.2rem">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card">
            <h2>Employee Record Settings</h2>
            <form action="{{ route('hr.employees.update', $employee) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-control">
                        <label>Employee Name</label>
                        <input type="text" class="input-text" value="{{ $employee->name }}" disabled>
                    </div>

                    <div class="form-control">
                        <label>Email Address</label>
                        <input type="email" class="input-text" value="{{ $employee->email }}" disabled>
                    </div>

                    <div class="form-control">
                        <label for="department_id">Department Assignment</label>
                        <select id="department_id" name="department_id" class="input-select">
                            <option value="">-- Select Department --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ (old('department_id', $employee->department_id) == $dept->id) ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label for="position">Job Position / Title</label>
                        <input type="text" id="position" name="position" class="input-text" placeholder="e.g. Senior Software Engineer" value="{{ old('position', $employee->position) }}">
                    </div>

                    <div class="form-control">
                        <label for="date_joined">Date Joined</label>
                        <input type="date" id="date_joined" name="date_joined" class="input-text" value="{{ old('date_joined', $employee->date_joined ? $employee->date_joined->format('Y-m-d') : '') }}">
                    </div>

                    <div class="form-control">
                        <label for="status">Account Status</label>
                        <select id="status" name="status" class="input-select" required>
                            <option value="active" {{ old('status', $employee->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $employee->status) === 'inactive' ? 'selected' : '' }}>Inactive (Deactivated)</option>
                        </select>
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn-yellow">Save Changes</button>
                    <a href="{{ route('hr.employees.index') }}" class="btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </section>
    </main>
</div>
</body>
</html>

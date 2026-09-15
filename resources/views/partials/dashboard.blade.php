<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ ucfirst($user->role) }} Dashboard | WorkNest</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box }
        body { margin: 0; background: #4A1F50; color: #F2E5D5; font-family: 'DM Sans', sans-serif }
        .layout { display: grid; grid-template-columns: 280px 1fr; min-height: 100vh }
        .sidebar { background: #341539; border-right: 1px solid rgba(209, 176, 193, .1); padding: 2.5rem 1.8rem; display: flex; flex-direction: column }
        .nav { margin: 3rem 0; padding: 0; list-style: none }
        .nav a { display: block; padding: .75rem 1rem; border-left: 3px solid #F6EB61; background: rgba(246, 235, 97, .04); color: #F6EB61; text-decoration: none; font-size: .9rem }
        .logout { width: 100%; margin-top: auto; border: 0; border-radius: 50px; background: #F6EB61; color: #000; padding: .65rem; font: 600 .9rem 'DM Sans', sans-serif; cursor: pointer }
        .main { padding: 3rem 4rem }
        .header { padding-bottom: 1.5rem; margin-bottom: 2.5rem; border-bottom: 1px solid rgba(209, 176, 193, .08) }
        .badge { display: inline-block; padding: .25rem .75rem; border-radius: 4px; background: rgba(246, 235, 97, .1); color: #F6EB61; font-size: .8rem; letter-spacing: 1px }
        .header h1 { margin: .7rem 0 .3rem; font: 700 2.6rem 'Cormorant Garamond', serif }
        .header p { margin: 0; color: #D1B0C1 }
        .card { max-width: 900px; padding: 2rem; border: 1px solid rgba(209, 176, 193, .1); border-radius: 14px; background: #341539 }
        .card h2 { margin: 0 0 .8rem; color: #F6EB61; font: 600 1.6rem 'Cormorant Garamond', serif }
        .card p { margin: 0; color: #D1B0C1; line-height: 1.7 }
        .table { width: 100%; border-collapse: collapse }
        .table th, .table td { padding: .9rem; text-align: left; border-bottom: 1px solid rgba(209, 176, 193, .1) }
        .table th { color: #D1B0C1; font-size: .78rem; letter-spacing: .8px; text-transform: uppercase }
        .danger { max-width: 900px; margin-top: 1.5rem; padding: 2rem; border: 1.5px solid rgba(192, 97, 106, .25); border-radius: 14px }
        .danger h2 { color: #C0616A; font-size: 1rem; margin: 0 0 .75rem }
        .danger p { color: #D1B0C1; font-size: .9rem; line-height: 1.6 }
        .danger button { border: 1.5px solid #C0616A; border-radius: 50px; background: transparent; color: #C0616A; padding: .65rem 1.5rem; font: 600 .9rem 'DM Sans', sans-serif; cursor: pointer }
        .danger button:hover { background: #C0616A; color: #000 }
        @media (max-width: 850px) {
            .layout { grid-template-columns: 1fr }
            .sidebar { min-height: auto; padding: 1.5rem }
            .nav { margin: 1.5rem 0 }
            .logout { margin-top: 1rem }
            .main { padding: 2rem 1.5rem }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        @include('partials.logo', ['height' => 40])
        <ul class="nav">
            <li><a href="{{ route($route ?? 'hr.dashboard') }}">Overview</a></li>
            @if(in_array(strtolower($user->role), ['hr', 'admin']))
                <li><a href="{{ route('hr.employees.index') }}">Employee Directory</a></li>
                <li><a href="{{ route('hr.departments.index') }}">Departments</a></li>
            @endif
            @if(strtolower($user->role) === 'admin')
                <li><a href="{{ route('admin.carousel.edit') }}">Carousel Slides</a></li>
            @endif
        </ul>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout">Logout</button>
        </form>
    </aside>
    <main class="main">
        <header class="header">
            <span class="badge">{{ $organization->name }}</span>
            <h1>Welcome, {{ $user->name }}</h1>
            <p>{{ ucfirst($user->role) }} - {{ $user->department ?? 'Administration' }} Department</p>
        </header>

        @if($user->role === 'admin')
            <section class="card">
                <h2>Organization members</h2>
                @if($members->isEmpty())
                    <p>No members have joined this organization yet.</p>
                @else
                    <div style="overflow:auto">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Role</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->department }}</td>
                                    <td>{{ $member->role }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            <section class="danger">
                <h2>Restricted Action</h2>
                <p>Deleting this organization deactivates its associated users and removes organization access.</p>
                <form action="{{ route('admin.organization.delete') }}" method="POST" onsubmit="return confirm('Delete this organization and deactivate all users?');">
                    @csrf
                    <button>Delete organization</button>
                </form>
            </section>
        @else
            <section class="card">
                <h2>{{ $heading }}</h2>
                <p>{{ $description }}</p>
            </section>
        @endif
    </main>
</div>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Control Center | WorkNest</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box }
        body { margin: 0; background: #F2E5D5; color: #341539; font-family: 'DM Sans', sans-serif }
        
        /* Layout Structure */
        .layout { display: grid; grid-template-columns: 280px 1fr; min-height: 100vh }
        
        /* Sidebar (Dark Purple #341539 with Ivory/Butter Yellow) */
        .sidebar { background: #341539; border-right: 1px solid rgba(209, 176, 193, .15); padding: 2.2rem 1.7rem; display: flex; flex-direction: column; justify-content: space-between }
        .sidebar-brand { font: 700 1.7rem 'Cormorant Garamond', serif; color: #FFF0C4; text-decoration: none; display: flex; align-items: center; gap: .5rem; margin-bottom: 2rem }
        .sidebar-brand span { color: #F6EB61 }
        .nav-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .5rem }
        .nav-item a { display: flex; align-items: center; gap: .75rem; padding: .75rem 1rem; border-radius: 8px; color: #FFF0C4; text-decoration: none; font-size: .92rem; font-weight: 500; transition: all .2s ease }
        .nav-item a:hover, .nav-item a.active { background: rgba(246, 235, 97, .12); color: #F6EB61; font-weight: 600 }
        .nav-item a.active { border-left: 3px solid #F6EB61 }
        .logout-btn { width: 100%; border: 0; border-radius: 50px; background: #F6EB61; color: #341539; padding: .75rem; font: 700 .9rem 'DM Sans', sans-serif; cursor: pointer; transition: background .2s ease }
        .logout-btn:hover { background: #FFF0C4 }
        
        /* Main Content Container (Light Cream #F2E5D5) */
        .main { background: #F2E5D5; padding: 2.5rem 3.5rem; color: #341539 }
        
        /* Top Navbar (Dark Purple #341539 header strip) */
        .top-navbar { background: #341539; border-radius: 12px; padding: 1.25rem 2rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; color: #FFF0C4; box-shadow: 0 4px 12px rgba(52, 21, 57, .08) }
        .top-navbar h1 { margin: 0; font: 700 1.8rem 'Cormorant Garamond', serif; color: #FFF0C4 }
        .top-navbar .tag { background: rgba(246, 235, 97, .15); color: #F6EB61; padding: .35rem .85rem; border-radius: 50px; font-size: .82rem; font-weight: 600; letter-spacing: .5px }
        
        /* Status Banner Alerts */
        .alert { padding: 1rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: .9rem; display: flex; justify-content: space-between; align-items: center }
        .alert-success { background: #E2F0D9; color: #2D5B1E; border-left: 4px solid #388E3C }
        .alert-danger { background: #FADBD8; color: #78281F; border-left: 4px solid #C0616A }
        
        /* Dashboard Section Titles */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin: 2rem 0 1rem }
        .section-title { font: 700 1.5rem 'Cormorant Garamond', serif; color: #341539; margin: 0 }
        
        /* Stat Cards Grid (Alternating Butter Yellow & Soft Mauve) */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; margin-bottom: 2rem }
        .stat-card { padding: 1.4rem 1.5rem; border-radius: 12px; color: #341539; box-shadow: 0 2px 8px rgba(52, 21, 57, .05); border: 1px solid rgba(52, 21, 57, .08) }
        .stat-card.yellow { background: #FFF0C4; border-top: 4px solid #F6EB61 }
        .stat-card.mauve { background: #D1B0C1; border-top: 4px solid #996A8C }
        .stat-label { font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #341539; opacity: .8; margin-bottom: .4rem }
        .stat-value { font: 700 2.2rem 'Cormorant Garamond', serif; color: #341539; margin: 0 }
        
        /* Panel Container Cards */
        .panel-card { background: #FFFFFF; border-radius: 14px; padding: 2rem; margin-bottom: 2rem; border: 1px solid rgba(52, 21, 57, .1); box-shadow: 0 4px 14px rgba(52, 21, 57, .04) }
        .panel-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(52, 21, 57, .08); padding-bottom: 1rem; margin-bottom: 1.5rem }
        .panel-header h2 { font: 700 1.4rem 'Cormorant Garamond', serif; color: #341539; margin: 0 }
        .panel-subtitle { color: #996A8C; font-size: .88rem; margin-top: .25rem }
        
        /* Tables */
        .table-responsive { overflow-x: auto }
        .table { width: 100%; border-collapse: collapse }
        .table th { background: #341539; color: #FFF0C4; text-align: left; padding: .85rem 1rem; font-size: .82rem; font-weight: 600; letter-spacing: .5px; text-transform: uppercase }
        .table td { padding: .85rem 1rem; border-bottom: 1px solid rgba(52, 21, 57, .08); font-size: .9rem; color: #341539; vertical-align: middle }
        .table tr:hover { background: rgba(242, 229, 213, .3) }
        
        /* Badges */
        .status-badge { display: inline-block; padding: .2rem .65rem; border-radius: 50px; font-size: .78rem; font-weight: 700 }
        .badge-active { background: #D4EFDF; color: #196F3D }
        .badge-inactive { background: #FADBD8; color: #78281F }
        .role-badge { display: inline-block; padding: .2rem .6rem; border-radius: 4px; font-weight: 600; font-size: .78rem; background: #D1B0C1; color: #341539 }
        .role-badge.admin { background: #341539; color: #F6EB61 }
        
        /* Form Inputs & Buttons */
        .form-group { margin-bottom: 1.25rem }
        .form-group label { display: block; font-size: .85rem; font-weight: 600; color: #341539; margin-bottom: .4rem }
        .form-control, .form-select { width: 100%; padding: .65rem .85rem; border-radius: 8px; border: 1px solid #996A8C; background: #FFF0C4; color: #341539; font: 400 .9rem 'DM Sans', sans-serif }
        .form-control:focus, .form-select:focus { outline: none; border-color: #341539; box-shadow: 0 0 0 3px rgba(52, 21, 57, .12) }
        
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; padding: .6rem 1.4rem; border-radius: 50px; border: 0; font: 700 .88rem 'DM Sans', sans-serif; cursor: pointer; text-decoration: none; transition: all .2s ease }
        .btn-primary { background: #341539; color: #FFF0C4 }
        .btn-primary:hover { background: #4A1F50; color: #F6EB61 }
        .btn-secondary { background: #F6EB61; color: #341539 }
        .btn-secondary:hover { background: #FFF0C4 }
        .btn-sm { padding: .35rem .85rem; font-size: .8rem; border-radius: 6px }
        .btn-danger { background: #C0616A; color: #FFF }
        .btn-danger:hover { background: #A04049 }
        
        /* Responsive */
        @media (max-width: 900px) {
            .layout { grid-template-columns: 1fr }
            .sidebar { padding: 1.5rem }
            .main { padding: 1.5rem }
            .stats-grid { grid-template-columns: 1fr 1fr }
        }
    </style>
</head>
<body>

<div class="layout">
    <!-- Sidebar (Dark Purple #341539 with Ivory/Butter Yellow) -->
    <aside class="sidebar">
        <div>
            <a href="/" class="sidebar-brand">
                <span>Work</span>Nest
            </a>
            <ul class="nav-list">
                <li class="nav-item"><a href="#overview" class="active">📊 Overview</a></li>
                <li class="nav-item"><a href="#users">👥 User Management</a></li>
                <li class="nav-item"><a href="#settings">⚙️ Organization Settings</a></li>
                <li class="nav-item"><a href="#carousel">🖼️ Carousel Slides</a></li>
                <li class="nav-item"><a href="#nest">🪹 Create Nest</a></li>
                <li class="nav-item"><a href="{{ route('hr.employees.index') }}">📁 Employee Directory</a></li>
                <li class="nav-item"><a href="{{ route('hr.departments.index') }}">🏢 Department Management</a></li>
            </ul>
        </div>
        
        <div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout System</button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area (Light Cream #F2E5D5 Background) -->
    <main class="main">
        <!-- Top Navbar Strip -->
        <header class="top-navbar">
            <div>
                <h1>Admin Control Center</h1>
                <span style="font-size: .88rem; color: #D1B0C1;">Managing {{ $organization->name }} Workspace</span>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span class="tag">Role: Administrator</span>
                <span style="font-size: .9rem; font-weight: 600;">{{ $user->name }}</span>
            </div>
        </header>

        <!-- Status / Feedback Messages -->
        @if(session('status'))
            <div class="alert alert-success">
                <span>✅ {{ session('status') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <div>
                    @foreach($errors->all() as $error)
                        <div>⚠️ {{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 1. ORGANIZATION OVERVIEW SECTION -->
        <section id="overview">
            <div class="section-header">
                <h2 class="section-title">Organization Overview</h2>
            </div>
            
            <div class="stats-grid">
                <!-- Total Employees (Butter Yellow) -->
                <div class="stat-card yellow">
                    <div class="stat-label">Total Employees</div>
                    <div class="stat-value">{{ $totalEmployees }}</div>
                </div>
                
                <!-- Total Departments (Soft Mauve) -->
                <div class="stat-card mauve">
                    <div class="stat-label">Total Departments</div>
                    <div class="stat-value">{{ $totalDepartments }}</div>
                </div>
                
                <!-- Admin Count (Butter Yellow) -->
                <div class="stat-card yellow">
                    <div class="stat-label">Admins</div>
                    <div class="stat-value">{{ $roleCounts['Admin'] }}</div>
                </div>

                <!-- CEO Count (Soft Mauve) -->
                <div class="stat-card mauve">
                    <div class="stat-label">CEOs</div>
                    <div class="stat-value">{{ $roleCounts['CEO'] }}</div>
                </div>

                <!-- HR Count (Butter Yellow) -->
                <div class="stat-card yellow">
                    <div class="stat-label">HR Members</div>
                    <div class="stat-value">{{ $roleCounts['HR'] }}</div>
                </div>

                <!-- Manager Count (Soft Mauve) -->
                <div class="stat-card mauve">
                    <div class="stat-label">Managers</div>
                    <div class="stat-value">{{ $roleCounts['Manager'] }}</div>
                </div>

                <!-- Employee Count (Butter Yellow) -->
                <div class="stat-card yellow">
                    <div class="stat-label">Employees</div>
                    <div class="stat-value">{{ $roleCounts['Employee'] }}</div>
                </div>

                <!-- Support Count (Soft Mauve) -->
                <div class="stat-card mauve">
                    <div class="stat-label">Support Team</div>
                    <div class="stat-value">{{ $roleCounts['Support'] }}</div>
                </div>
            </div>
        </section>

        <!-- 2. USER MANAGEMENT SECTION -->
        <section id="users" class="panel-card">
            <div class="panel-header">
                <div>
                    <h2>User Management</h2>
                    <div class="panel-subtitle">Manage organization member roles and active permissions</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Current Role</th>
                            <th>Status</th>
                            <th>Change Role</th>
                            <th>Account Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allUsers as $member)
                            <tr>
                                <td><strong>{{ $member->name }}</strong></td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->department ?? 'General' }}</td>
                                <td>
                                    <span class="role-badge {{ strtolower($member->role) === 'admin' ? 'admin' : '' }}">
                                        {{ $member->role }}
                                    </span>
                                </td>
                                <td>
                                    @if($member->is_active)
                                        <span class="status-badge badge-active">Active</span>
                                    @else
                                        <span class="status-badge badge-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Edit Role Form -->
                                    <form action="{{ route('admin.users.update-role', $member->id) }}" method="POST" style="display: flex; gap: .5rem;">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="form-select" style="padding: .25rem .5rem; font-size: .82rem; width: auto;">
                                            @foreach(['admin', 'CEO', 'HR', 'Manager', 'Employee', 'Support'] as $roleOption)
                                                <option value="{{ $roleOption }}" {{ strtolower($member->role) === strtolower($roleOption) ? 'selected' : '' }}>
                                                    {{ $roleOption }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <!-- Toggle Active / Deactivate Form -->
                                    @if($member->id !== $user->id)
                                        <form action="{{ route('admin.users.toggle-status', $member->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            @if($member->is_active)
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deactivate account for {{ $member->name }}?');">
                                                    Deactivate
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-secondary btn-sm">
                                                    Reactivate
                                                </button>
                                            @endif
                                        </form>
                                    @else
                                        <span style="font-size: .8rem; color: #996A8C; font-style: italic;">Primary Admin</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 3. ORGANIZATION SETTINGS & CAROUSEL SLIDES SECTION -->
        <section id="settings" class="panel-card">
            <div class="panel-header">
                <div>
                    <h2>Organization Settings</h2>
                    <div class="panel-subtitle">Update organization details and general workspace identity</div>
                </div>
            </div>

            <!-- Edit Organization Name Form -->
            <form action="{{ route('admin.organization.update-name') }}" method="POST" style="max-width: 600px; margin-bottom: 2rem;">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="org_name">Organization Name</label>
                    <input id="org_name" name="name" type="text" class="form-control" value="{{ $organization->name }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Save Organization Name</button>
            </form>

            <hr style="border: 0; border-top: 1px solid rgba(52, 21, 57, .1); margin: 2.5rem 0;">

            <!-- Carousel Slides Management -->
            <div id="carousel" class="panel-header">
                <div>
                    <h2>Homepage Carousel Slides</h2>
                    <div class="panel-subtitle">Create, edit, or remove slides displayed on the public landing homepage</div>
                </div>
            </div>

            <!-- Add New Slide Form -->
            <div style="background: #FFF0C4; border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem; border: 1px solid #F6EB61;">
                <h3 style="font: 700 1.1rem 'Cormorant Garamond', serif; color: #341539; margin-top: 0; margin-bottom: 1rem;">➕ Create New Carousel Slide</h3>
                <form action="{{ route('admin.carousel.store') }}" method="POST">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="new_title">Slide Title</label>
                            <input id="new_title" name="title" type="text" class="form-control" placeholder="e.g. Organization Clarity" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="new_subtitle">Slide Subtitle (Eyebrow)</label>
                            <input id="new_subtitle" name="subtitle" type="text" class="form-control" placeholder="e.g. 01 / ORGANIZATION">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_desc">Slide Description</label>
                        <textarea id="new_desc" name="description" class="form-control" rows="2" placeholder="Brief description visible on homepage carousel" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Carousel Slide</button>
                </form>
            </div>

            <!-- Existing Slides List -->
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                @foreach($slides as $slide)
                    <div style="background: #D1B0C1; border-radius: 10px; padding: 1.5rem; border: 1px solid #996A8C;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <h4 style="margin: 0; font: 700 1.1rem 'Cormorant Garamond', serif; color: #341539;">
                                Slide #{{ $slide->position }}: {{ $slide->title }}
                            </h4>
                            <form action="{{ route('admin.carousel.destroy-slide', $slide->id) }}" method="POST" onsubmit="return confirm('Delete this carousel slide?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete Slide</button>
                            </form>
                        </div>

                        <!-- Update Slide Form -->
                        <form action="{{ route('admin.carousel.update-slide', $slide->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label>Title</label>
                                    <input name="title" type="text" class="form-control" value="{{ $slide->title }}" required>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label>Subtitle</label>
                                    <input name="subtitle" type="text" class="form-control" value="{{ $slide->subtitle }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="2" required>{{ $slide->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Update Slide</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 4. CREATE NEST ACCESS SECTION -->
        <section id="nest" class="panel-card">
            <div class="panel-header">
                <div>
                    <h2>🪹 Create Nest (Team Workspace / Group Chat)</h2>
                    <div class="panel-subtitle">Provision dedicated team workspaces and group communication nests</div>
                </div>
            </div>

            <form action="{{ route('admin.nests.create') }}" method="POST" style="max-width: 650px;">
                @csrf
                <div class="form-group">
                    <label for="nest_name">Nest Name</label>
                    <input id="nest_name" name="nest_name" type="text" class="form-control" placeholder="e.g. Q4 Strategy & Operations Nest" required>
                </div>

                <div class="form-group">
                    <label for="nest_department">Target Department</label>
                    <select id="nest_department" name="department" class="form-select" required>
                        <option value="All Departments">All Departments (Organization-Wide)</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Finance">Finance</option>
                        <option value="HR">HR</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Operations">Operations</option>
                        <option value="Sales">Sales</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nest_description">Nest Purpose / Description</label>
                    <textarea id="nest_description" name="description" class="form-control" rows="3" placeholder="Outline objectives, channel focus, and team guidelines..."></textarea>
                </div>

                <button type="submit" class="btn btn-secondary">🚀 Launch New Nest</button>
            </form>
        </section>

        <!-- 5. RESTRICTED DANGER ZONE -->
        <section class="panel-card" style="border: 1.5px solid #C0616A; background: #FADBD8;">
            <div class="panel-header" style="border-bottom-color: rgba(192, 97, 106, .2);">
                <div>
                    <h2 style="color: #78281F;">⚠️ Restricted Action: Deactivate Organization</h2>
                    <div class="panel-subtitle" style="color: #922B21;">Deactivates the organization and disables access for all members</div>
                </div>
            </div>
            
            <p style="color: #78281F; font-size: .9rem; line-height: 1.6; margin-bottom: 1.5rem;">
                Deactivating <strong>{{ $organization->name }}</strong> will immediately set all member accounts to inactive state and disable workspace access. This action requires founder approval.
            </p>

            <form action="{{ route('admin.organization.delete') }}" method="POST" onsubmit="return confirm('ARE YOU SURE? This will deactivate {{ $organization->name }} and block all member access.');">
                @csrf
                <button type="submit" class="btn btn-danger">Deactivate Entire Organization</button>
            </form>
        </section>
    </main>
</div>

</body>
</html>

<!-- WorkNest Sidebar Blade Partial -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar__brand">
    <div class="sidebar__logo">WN</div>
    <div>
      <h1 class="sidebar__title">WorkNest</h1>
      <span class="sidebar__role-pill" id="sidebarRoleTag">Portal</span>
    </div>
  </div>

  <nav class="sidebar__nav">
    <div class="sidebar__section-title">Main Navigation</div>

    <a href="{{ url('/admin/dashboard') }}" class="sidebar__link {{ request()->is('admin*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-chart-pie"></i> Admin Console
    </a>

    <a href="{{ url('/ceo/dashboard') }}" class="sidebar__link {{ request()->is('ceo*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-chart-line"></i> Executive Analytics
    </a>

    <a href="{{ url('/hr/dashboard') }}" class="sidebar__link {{ request()->is('hr/dashboard*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-users"></i> HR Dashboard
    </a>
    <a href="{{ url('/hr/employees') }}" class="sidebar__link {{ request()->is('hr/employees*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-id-card"></i> Employee Directory
    </a>

    <a href="{{ url('/manager/dashboard') }}" class="sidebar__link {{ request()->is('manager/dashboard*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-user-group"></i> My Team Overview
    </a>
    <a href="{{ url('/manager/tasks') }}" class="sidebar__link {{ request()->is('manager/tasks*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-list-check"></i> Task Board
    </a>

    <a href="{{ url('/employee/dashboard') }}" class="sidebar__link {{ request()->is('employee/dashboard*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-house-user"></i> My Dashboard
    </a>
    <a href="{{ url('/employee/attendance') }}" class="sidebar__link {{ request()->is('employee/attendance*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-clock"></i> Attendance Log
    </a>
    <a href="{{ url('/employee/leave') }}" class="sidebar__link {{ request()->is('employee/leave*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-calendar-minus"></i> Apply Leave
    </a>

    <a href="{{ url('/support/dashboard') }}" class="sidebar__link {{ request()->is('support*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-headset"></i> Support Desk
    </a>

    <div class="sidebar__section-title" style="margin-top: 1rem;">System & Utils</div>
    <a href="{{ url('/shared/profile') }}" class="sidebar__link {{ request()->is('shared/profile*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-user-gear"></i> Account Settings
    </a>
    <a href="{{ url('/components-guide') }}" class="sidebar__link {{ request()->is('components-guide*') ? 'is-active' : '' }}">
      <i class="fa-solid fa-swatchbook"></i> Style Guide
    </a>
    <a href="{{ url('/login') }}" class="sidebar__link" style="color: var(--ivory);">
      <i class="fa-solid fa-right-from-bracket"></i> Sign Out
    </a>
  </nav>

  <div class="sidebar__footer">
    <div style="font-size: 0.75rem; color: var(--soft-mauve); text-align: center;">
      WorkNest Laravel v2.4.0
    </div>
  </div>
</aside>

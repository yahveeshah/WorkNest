@extends('layouts.app')

@section('title', 'WorkNest - Admin Dashboard')

@section('content')
<div class="page-header">
  <div>
    <h1>Admin Control Panel</h1>
    <p>System-wide user provisioning, role assignments, global settings, and audit trace.</p>
  </div>
  <div class="page-header__actions">
    <button class="btn btn--primary" data-modal-target="addUserModal">
      <i class="fa-solid fa-user-plus"></i> Add New User
    </button>
  </div>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-4" style="margin-bottom: 2rem;">
  <div class="card card--stat">
    <div class="stat-content">
      <div class="stat-label">Total Users</div>
      <div class="stat-value">248</div>
      <div class="stat-trend stat-trend--up"><i class="fa-solid fa-arrow-up"></i> 14 Added this month</div>
    </div>
    <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
  </div>

  <div class="card card--stat">
    <div class="stat-content">
      <div class="stat-label">Active Roles</div>
      <div class="stat-value">6 Roles</div>
      <div class="stat-trend stat-trend--up"><i class="fa-solid fa-shield-halved"></i> RBAC Enabled</div>
    </div>
    <div class="stat-icon"><i class="fa-solid fa-user-shield"></i></div>
  </div>

  <div class="card card--stat">
    <div class="stat-content">
      <div class="stat-label">System Health</div>
      <div class="stat-value">99.98%</div>
      <div class="stat-trend stat-trend--up"><i class="fa-solid fa-server"></i> All Systems Operational</div>
    </div>
    <div class="stat-icon"><i class="fa-solid fa-heart-pulse"></i></div>
  </div>

  <div class="card card--stat">
    <div class="stat-content">
      <div class="stat-label">Audit Logs</div>
      <div class="stat-value">1,420</div>
      <div class="stat-trend stat-trend--up"><i class="fa-solid fa-history"></i> Real-time Logging</div>
    </div>
    <div class="stat-icon"><i class="fa-solid fa-receipt"></i></div>
  </div>
</div>

<!-- User Management Table Card -->
<div class="card" style="margin-bottom: 2rem;">
  <div class="card__header">
    <div>
      <h2 class="card__title">User Management & Role Permissions</h2>
      <div class="card__subtitle">Manage credentials, active state, and assigned authorization roles</div>
    </div>
    <div style="display:flex; gap: 0.5rem;">
      <select class="form-select" style="width: auto; padding: 0.375rem 0.75rem;">
        <option>All Roles</option>
        <option>Admin</option>
        <option>CEO</option>
        <option>HR</option>
        <option>Manager</option>
        <option>Employee</option>
      </select>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table--striped table--hover">
      <thead>
        <tr>
          <th>User Profile</th>
          <th>Department</th>
          <th>Assigned Role</th>
          <th>Last Active</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <div style="display:flex; align-items:center; gap: 0.75rem;">
              <div class="avatar avatar--sm">AW</div>
              <div>
                <strong>Alexander Wright</strong>
                <div style="font-size: 0.75rem; color: var(--text-muted);">alexander@worknest.io</div>
              </div>
            </div>
          </td>
          <td>IT & Infrastructure</td>
          <td><span class="badge badge--info">System Admin</span></td>
          <td>Just now</td>
          <td><span class="badge badge--success">Active</span></td>
          <td>
            <button class="btn btn--outline btn--sm"><i class="fa-solid fa-pen"></i></button>
            <button class="btn btn--secondary btn--sm"><i class="fa-solid fa-lock"></i></button>
          </td>
        </tr>
        <tr>
          <td>
            <div style="display:flex; align-items:center; gap: 0.75rem;">
              <div class="avatar avatar--sm">EM</div>
              <div>
                <strong>Elena Rostova</strong>
                <div style="font-size: 0.75rem; color: var(--text-muted);">elena@worknest.io</div>
              </div>
            </div>
          </td>
          <td>Executive Suite</td>
          <td><span class="badge badge--info">CEO</span></td>
          <td>12 mins ago</td>
          <td><span class="badge badge--success">Active</span></td>
          <td>
            <button class="btn btn--outline btn--sm"><i class="fa-solid fa-pen"></i></button>
            <button class="btn btn--secondary btn--sm"><i class="fa-solid fa-lock"></i></button>
          </td>
        </tr>
        <tr>
          <td>
            <div style="display:flex; align-items:center; gap: 0.75rem;">
              <div class="avatar avatar--sm">SL</div>
              <div>
                <strong>Sarah Lindqvist</strong>
                <div style="font-size: 0.75rem; color: var(--text-muted);">sarah.l@worknest.io</div>
              </div>
            </div>
          </td>
          <td>Human Resources</td>
          <td><span class="badge badge--info">HR Manager</span></td>
          <td>1 hour ago</td>
          <td><span class="badge badge--success">Active</span></td>
          <td>
            <button class="btn btn--outline btn--sm"><i class="fa-solid fa-pen"></i></button>
            <button class="btn btn--secondary btn--sm"><i class="fa-solid fa-lock"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Settings & Audit Logs Grid -->
<div class="grid grid-cols-2">
  <div class="card">
    <div class="card__header">
      <h2 class="card__title"><i class="fa-solid fa-sliders"></i> Global System Settings</h2>
    </div>
    <div class="card__body">
      <div class="form-group">
        <label class="form-label">Organization Name</label>
        <input type="text" class="form-control" value="WorkNest Enterprise Solutions Ltd.">
      </div>
      <div class="form-group">
        <label class="form-label">Standard Working Hours</label>
        <div style="display:flex; gap: 0.5rem;">
          <input type="time" class="form-control" value="09:00">
          <span style="align-self: center;">to</span>
          <input type="time" class="form-control" value="17:30">
        </div>
      </div>
      <button class="btn btn--primary"><i class="fa-solid fa-floppy-disk"></i> Save System Config</button>
    </div>
  </div>

  <div class="card">
    <div class="card__header">
      <h2 class="card__title"><i class="fa-solid fa-shield-cat"></i> System Audit Log</h2>
    </div>
    <div class="card__body" style="padding: 0;">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Timestamp</th>
              <th>Actor</th>
              <th>Action Executed</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="font-size: 0.75rem;">Today, 14:32</td>
              <td><strong>Alexander W.</strong></td>
              <td>Created user profile <code>johndoe@worknest.io</code></td>
            </tr>
            <tr>
              <td style="font-size: 0.75rem;">Today, 11:15</td>
              <td><strong>Sarah L.</strong></td>
              <td>Approved leave request #LR-908</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add User Modal -->
<div class="modal-backdrop" id="addUserModal">
  <div class="modal">
    <div class="modal__header">
      <h3 class="card__title">Provision New User Account</h3>
      <button class="modal__close" data-modal-close>&times;</button>
    </div>
    <div class="modal__body">
      <form id="addUserForm" data-validate>
        <div class="form-group">
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" placeholder="e.g. Rachel Adams" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" class="form-control" placeholder="rachel@worknest.io" required>
        </div>
      </form>
    </div>
    <div class="modal__footer">
      <button class="btn btn--outline" data-modal-close>Cancel</button>
      <button class="btn btn--primary" onclick="showToast('User provisioned successfully!', 'success'); document.getElementById('addUserModal').classList.remove('is-active');">Create User</button>
    </div>
  </div>
</div>
@endsection

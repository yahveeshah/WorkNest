<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WorkNest - Sign In</title>
  <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #341539 0%, #200C24 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }

    .auth-card {
      width: 100%;
      max-width: 440px;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(12px);
      border-radius: var(--radius-lg);
      padding: 2.5rem 2rem;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
      border: 1px solid rgba(209, 176, 193, 0.3);
    }

    .auth-brand {
      text-align: center;
      margin-bottom: 2rem;
    }

    .auth-logo {
      width: 56px;
      height: 56px;
      background-color: var(--dark-purple);
      color: var(--ivory);
      border-radius: var(--radius-md);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: 1.75rem;
      margin: 0 auto 0.75rem;
      box-shadow: var(--shadow-md);
    }
  </style>
</head>
<body>

  <div class="auth-card">
    <div class="auth-brand">
      <div class="auth-logo">WN</div>
      <h1 style="color: var(--dark-purple); font-size: 1.75rem; font-weight: 800;">WorkNest</h1>
      <p style="color: var(--text-muted); font-size: 0.875rem; margin-top: 0.25rem;">Employee Management System</p>
    </div>

    <form id="loginForm" data-validate>
      <div class="form-group">
        <label class="form-label" for="loginEmail">Work Email Address</label>
        <div style="position: relative;">
          <input type="email" id="loginEmail" class="form-control" placeholder="name@company.com" required value="admin@worknest.io" style="padding-left: 2.5rem;">
          <i class="fa-regular fa-envelope" style="position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); color: var(--muted-purple);"></i>
        </div>
      </div>

      <div class="form-group">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.375rem;">
          <label class="form-label" for="loginPassword" style="margin-bottom: 0;">Password</label>
          <a href="{{ url('/forgot-password') }}" style="font-size: 0.8125rem; font-weight: 600; color: var(--dark-purple);">Forgot password?</a>
        </div>
        <div style="position: relative;">
          <input type="password" id="loginPassword" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required value="password123" style="padding-left: 2.5rem;">
          <i class="fa-solid fa-lock" style="position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); color: var(--muted-purple);"></i>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 1.5rem;">
        <label class="form-check">
          <input type="checkbox" class="form-check__input" checked>
          <span>Remember this device for 30 days</span>
        </label>
      </div>

      <button type="submit" class="btn btn--primary btn--lg w-full" style="width: 100%;">
        Sign In to Portal <i class="fa-solid fa-arrow-right"></i>
      </button>
    </form>

    <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.25rem; text-align: center;">
      <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">
        Quick Role Demo Access
      </div>
      <div style="display: flex; flex-wrap: wrap; gap: 0.375rem; justify-content: center;">
        <a href="{{ url('/admin/dashboard') }}" class="btn btn--outline btn--sm">Admin</a>
        <a href="{{ url('/ceo/dashboard') }}" class="btn btn--outline btn--sm">CEO</a>
        <a href="{{ url('/hr/dashboard') }}" class="btn btn--outline btn--sm">HR</a>
        <a href="{{ url('/manager/dashboard') }}" class="btn btn--outline btn--sm">Manager</a>
        <a href="{{ url('/employee/dashboard') }}" class="btn btn--outline btn--sm">Employee</a>
        <a href="{{ url('/support/dashboard') }}" class="btn btn--outline btn--sm">Support</a>
      </div>
      <div style="margin-top: 1rem;">
        <a href="{{ url('/components-guide') }}" style="font-size: 0.8125rem; font-weight: 600; color: var(--muted-purple); text-decoration: underline;">
          <i class="fa-solid fa-swatchbook"></i> View Design System & Component Library
        </a>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script>
    document.getElementById('loginForm').addEventListener('submit', (e) => {
      e.preventDefault();
      const email = document.getElementById('loginEmail').value.toLowerCase();
      let target = '{{ url("/admin/dashboard") }}';
      if (email.includes('ceo')) target = '{{ url("/ceo/dashboard") }}';
      else if (email.includes('hr')) target = '{{ url("/hr/dashboard") }}';
      else if (email.includes('manager')) target = '{{ url("/manager/dashboard") }}';
      else if (email.includes('employee')) target = '{{ url("/employee/dashboard") }}';
      else if (email.includes('support')) target = '{{ url("/support/dashboard") }}';

      window.location.href = target;
    });
  </script>
</body>
</html>

/**
 * WorkNest Core JavaScript
 * Handles layout interactivity, role switching, modals, dropdowns, and form validation.
 */

document.addEventListener('DOMContentLoaded', () => {
  initSidebar();
  initRoleSwitcher();
  initModals();
  initDropdowns();
  initFormValidation();
  initTooltips();
});

/* ==========================================================================
   1. Mobile Sidebar Toggle
   ========================================================================== */
function initSidebar() {
  const toggleBtn = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');
  
  if (!sidebar) return;

  // Create overlay if not present
  let overlay = document.querySelector('.sidebar-overlay');
  if (!overlay) {
    overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);
  }

  if (toggleBtn) {
    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      sidebar.classList.toggle('is-open');
      overlay.classList.toggle('is-active');
    });
  }

  overlay.addEventListener('click', () => {
    sidebar.classList.remove('is-open');
    overlay.classList.remove('is-active');
  });
}

/* ==========================================================================
   2. Interactive Role Switcher
   ========================================================================== */
function initRoleSwitcher() {
  const switcher = document.getElementById('roleSelect');
  if (!switcher) return;

  // Sync role select with current page URL path if matched
  const currentPath = window.location.pathname.toLowerCase();
  if (currentPath.includes('/admin/')) switcher.value = 'admin';
  else if (currentPath.includes('/ceo/')) switcher.value = 'ceo';
  else if (currentPath.includes('/hr/')) switcher.value = 'hr';
  else if (currentPath.includes('/manager/')) switcher.value = 'manager';
  else if (currentPath.includes('/employee/')) switcher.value = 'employee';
  else if (currentPath.includes('/support/')) switcher.value = 'support';

  switcher.addEventListener('change', (e) => {
    const role = e.target.value;
    const paths = {
      admin: '../admin/dashboard.html',
      ceo: '../ceo/dashboard.html',
      hr: '../hr/dashboard.html',
      manager: '../manager/dashboard.html',
      employee: '../employee/dashboard.html',
      support: '../support/dashboard.html'
    };

    // If currently on root level page
    let target = paths[role];
    if (window.location.pathname.endsWith('index.html') || window.location.pathname.endsWith('components-guide.html')) {
      target = `pages/${role}/dashboard.html`;
    } else if (!window.location.pathname.includes('/pages/')) {
      target = `pages/${role}/dashboard.html`;
    }

    window.location.href = target;
  });
}

/* ==========================================================================
   3. Modal Controllers
   ========================================================================== */
function initModals() {
  const modalTriggers = document.querySelectorAll('[data-modal-target]');
  const modalDismissers = document.querySelectorAll('[data-modal-close]');

  modalTriggers.forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.getAttribute('data-modal-target');
      const modal = document.getElementById(targetId);
      if (modal) {
        modal.classList.add('is-active');
      }
    });
  });

  modalDismissers.forEach(btn => {
    btn.addEventListener('click', () => {
      const modal = btn.closest('.modal-backdrop');
      if (modal) {
        modal.classList.remove('is-active');
      }
    });
  });

  // Close when clicking outside modal content
  document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
    backdrop.addEventListener('click', (e) => {
      if (e.target === backdrop) {
        backdrop.classList.remove('is-active');
      }
    });
  });
}

/* ==========================================================================
   4. Simple Dropdown Handling
   ========================================================================== */
function initDropdowns() {
  const dropdownBtns = document.querySelectorAll('.dropdown-toggle');
  
  dropdownBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const parent = btn.closest('.dropdown');
      const menu = parent ? parent.querySelector('.dropdown-menu') : null;
      if (menu) {
        menu.classList.toggle('show');
      }
    });
  });

  document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
      menu.classList.remove('show');
    });
  });
}

/* ==========================================================================
   5. Form Validation States
   ========================================================================== */
function initFormValidation() {
  const forms = document.querySelectorAll('form[data-validate]');

  forms.forEach(form => {
    form.addEventListener('submit', (e) => {
      let isValid = true;
      const inputs = form.querySelectorAll('[required]');

      inputs.forEach(input => {
        const hint = input.parentNode.querySelector('.form-hint--error');
        if (!input.value.trim()) {
          isValid = false;
          input.classList.add('form-control--error');
          if (!hint) {
            const errorMsg = document.createElement('span');
            errorMsg.className = 'form-hint form-hint--error';
            errorMsg.textContent = 'This field is required';
            input.parentNode.appendChild(errorMsg);
          }
        } else {
          input.classList.remove('form-control--error');
          if (hint) hint.remove();
        }
      });

      if (!isValid) {
        e.preventDefault();
      }
    });
  });
}

/* Helper to show simple alert toasts */
function showToast(message, type = 'info') {
  let toastContainer = document.getElementById('toastContainer');
  if (!toastContainer) {
    toastContainer = document.createElement('div');
    toastContainer.id = 'toastContainer';
    toastContainer.style.cssText = 'position: fixed; bottom: 20px; right: 20px; z-index: 2000; display: flex; flex-direction: column; gap: 10px;';
    document.body.appendChild(toastContainer);
  }

  const toast = document.createElement('div');
  toast.className = `badge badge--${type}`;
  toast.style.cssText = 'padding: 12px 18px; font-size: 0.875rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(52,21,57,0.15); background-color: var(--dark-purple); color: var(--ivory); font-weight: 600; animation: fadeIn 0.3s ease;';
  toast.innerHTML = `<i class="fa-solid fa-circle-info"></i> ${message}`;
  
  toastContainer.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.3s ease';
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

function initTooltips() {}

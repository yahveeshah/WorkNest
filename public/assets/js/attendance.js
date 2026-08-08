/**
 * WorkNest - Employee Attendance Tracker & Timer Script (Laravel Compatible)
 */

document.addEventListener('DOMContentLoaded', () => {
  initAttendanceWidget();
});

function initAttendanceWidget() {
  const clockEl = document.getElementById('digitalClock');
  const checkBtn = document.getElementById('checkInBtn');
  const statusBadge = document.getElementById('attendanceStatusBadge');
  const timerDisplay = document.getElementById('activeWorkTimer');
  const ring = document.getElementById('attendanceRingProgress');

  if (clockEl) {
    setInterval(() => {
      const now = new Date();
      clockEl.textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }, 1000);
  }

  let isCheckedIn = false;
  let workSeconds = 27720;
  let timerInterval = null;

  if (checkBtn) {
    checkBtn.addEventListener('click', () => {
      isCheckedIn = !isCheckedIn;

      if (isCheckedIn) {
        checkBtn.textContent = 'Check Out';
        checkBtn.className = 'btn btn--danger btn--lg w-full';
        if (statusBadge) {
          statusBadge.textContent = 'Present / Working';
          statusBadge.className = 'badge badge--success';
        }
        if (typeof showToast === 'function') {
          showToast('Checked in successfully! Have a productive day.', 'success');
        }

        timerInterval = setInterval(() => {
          workSeconds++;
          updateTimerDisplay(workSeconds, timerDisplay, ring);
        }, 1000);

      } else {
        checkBtn.textContent = 'Check In';
        checkBtn.className = 'btn btn--primary btn--lg w-full';
        if (statusBadge) {
          statusBadge.textContent = 'Checked Out';
          statusBadge.className = 'badge badge--pending';
        }
        clearInterval(timerInterval);
        if (typeof showToast === 'function') {
          showToast('Checked out for today. See you tomorrow!', 'info');
        }
      }
    });
  }
}

function updateTimerDisplay(totalSeconds, displayEl, ringEl) {
  const hrs = Math.floor(totalSeconds / 3600);
  const mins = Math.floor((totalSeconds % 3600) / 60);
  const secs = totalSeconds % 60;

  if (displayEl) {
    displayEl.textContent = `${pad(hrs)}:${pad(mins)}:${pad(secs)}`;
  }

  if (ringEl) {
    const target = 28800;
    const pct = Math.min(1, totalSeconds / target);
    const circumference = 282.74;
    const strokeDashoffset = circumference * (1 - pct);
    ringEl.style.strokeDashoffset = strokeDashoffset;
  }
}

function pad(num) {
  return num < 10 ? '0' + num : num;
}

/**
 * WorkNest - Chart.js Visualizations (Laravel Herd Compatible)
 */

document.addEventListener('DOMContentLoaded', () => {
  initCEOCharts();
});

function initCEOCharts() {
  if (typeof Chart !== 'undefined') {
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#6B5267';
  }

  const attendanceCtx = document.getElementById('attendanceChart');
  if (attendanceCtx && typeof Chart !== 'undefined') {
    new Chart(attendanceCtx, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        datasets: [{
          label: 'Attendance %',
          data: [94, 98, 96, 99, 93, 88],
          borderColor: '#341539',
          backgroundColor: 'rgba(52, 21, 57, 0.08)',
          borderWidth: 3,
          fill: true,
          tension: 0.35,
          pointBackgroundColor: '#FFF0C4',
          pointBorderColor: '#341539',
          pointBorderWidth: 2,
          pointRadius: 5
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { min: 80, max: 100, grid: { color: 'rgba(153, 106, 140, 0.15)' } },
          x: { grid: { display: false } }
        }
      }
    });
  }

  const deptCtx = document.getElementById('deptProductivityChart');
  if (deptCtx && typeof Chart !== 'undefined') {
    new Chart(deptCtx, {
      type: 'bar',
      data: {
        labels: ['Engineering', 'HR & Ops', 'Marketing', 'Sales', 'Product', 'Customer Support'],
        datasets: [{
          label: 'Productivity Index',
          data: [92, 88, 85, 95, 90, 87],
          backgroundColor: ['#341539', '#996A8C', '#D1B0C1', '#341539', '#996A8C', '#D1B0C1'],
          borderRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { min: 0, max: 100, grid: { color: 'rgba(153, 106, 140, 0.15)' } },
          x: { grid: { display: false } }
        }
      }
    });
  }

  const taskRatioCtx = document.getElementById('taskRatioChart');
  if (taskRatioCtx && typeof Chart !== 'undefined') {
    new Chart(taskRatioCtx, {
      type: 'doughnut',
      data: {
        labels: ['Completed', 'In Progress', 'Under Review', 'Delayed'],
        datasets: [{
          data: [58, 24, 12, 6],
          backgroundColor: ['#341539', '#996A8C', '#D1B0C1', '#FFF0C4'],
          borderWidth: 2,
          borderColor: '#FFFFFF'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '72%',
        plugins: { legend: { position: 'bottom' } }
      }
    });
  }
}

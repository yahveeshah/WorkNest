/**
 * WorkNest - Chart.js Visualizations
 * Strictly styled using the WorkNest Brand Palette:
 * Dark Purple (#341539), Muted Purple (#996A8C), Soft Mauve (#D1B0C1), Ivory (#FFF0C4)
 */

document.addEventListener('DOMContentLoaded', () => {
  initCEOCharts();
});

function initCEOCharts() {
  // Chart font family
  if (typeof Chart !== 'undefined') {
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#6B5267';
  }

  // 1. Attendance Trend (Line Chart)
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
          pointRadius: 5,
          pointHoverRadius: 7
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#341539',
            titleColor: '#FFF0C4',
            bodyColor: '#F2E5D5',
            padding: 10,
            cornerRadius: 8
          }
        },
        scales: {
          y: {
            min: 80,
            max: 100,
            grid: { color: 'rgba(153, 106, 140, 0.15)' },
            ticks: { callback: value => value + '%' }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });
  }

  // 2. Department Productivity (Bar Chart)
  const deptCtx = document.getElementById('deptProductivityChart');
  if (deptCtx && typeof Chart !== 'undefined') {
    new Chart(deptCtx, {
      type: 'bar',
      data: {
        labels: ['Engineering', 'HR & Ops', 'Marketing', 'Sales', 'Product', 'Customer Support'],
        datasets: [{
          label: 'Productivity Index',
          data: [92, 88, 85, 95, 90, 87],
          backgroundColor: [
            '#341539',
            '#996A8C',
            '#D1B0C1',
            '#341539',
            '#996A8C',
            '#D1B0C1'
          ],
          borderRadius: 6,
          borderSkipped: false
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#341539',
            titleColor: '#FFF0C4',
            bodyColor: '#F2E5D5',
            padding: 10,
            cornerRadius: 8
          }
        },
        scales: {
          y: {
            min: 0,
            max: 100,
            grid: { color: 'rgba(153, 106, 140, 0.15)' }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });
  }

  // 3. Task Completion Ratio (Donut Chart)
  const taskRatioCtx = document.getElementById('taskRatioChart');
  if (taskRatioCtx && typeof Chart !== 'undefined') {
    new Chart(taskRatioCtx, {
      type: 'doughnut',
      data: {
        labels: ['Completed', 'In Progress', 'Under Review', 'Delayed'],
        datasets: [{
          data: [58, 24, 12, 6],
          backgroundColor: [
            '#341539', // Dark Purple (Completed)
            '#996A8C', // Muted Purple (In Progress)
            '#D1B0C1', // Soft Mauve (Review)
            '#FFF0C4'  // Ivory / Yellow (Delayed)
          ],
          borderWidth: 2,
          borderColor: '#FFFFFF',
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '72%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              usePointStyle: true,
              padding: 16,
              font: { size: 12, weight: '600' }
            }
          },
          tooltip: {
            backgroundColor: '#341539',
            titleColor: '#FFF0C4',
            bodyColor: '#F2E5D5',
            padding: 10,
            cornerRadius: 8
          }
        }
      }
    });
  }
}

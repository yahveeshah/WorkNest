/**
 * WorkNest - Interactive Kanban Task Board Script
 * Enables drag & drop task card movements across columns (To Do, In Progress, Review, Done)
 */

document.addEventListener('DOMContentLoaded', () => {
  initKanban();
});

function initKanban() {
  const cards = document.querySelectorAll('.kanban-card');
  const columns = document.querySelectorAll('.kanban-column__body');

  let draggedCard = null;

  cards.forEach(card => {
    card.setAttribute('draggable', 'true');

    card.addEventListener('dragstart', (e) => {
      draggedCard = card;
      card.classList.add('is-dragging');
      e.dataTransfer.effectAllowed = 'move';
      e.dataTransfer.setData('text/plain', card.id || '');
    });

    card.addEventListener('dragend', () => {
      card.classList.remove('is-dragging');
      draggedCard = null;
      updateColumnCounts();
    });
  });

  columns.forEach(column => {
    column.addEventListener('dragover', (e) => {
      e.preventDefault();
      e.dataTransfer.dropEffect = 'move';
      column.classList.add('is-drag-over');
    });

    column.addEventListener('dragleave', () => {
      column.classList.remove('is-drag-over');
    });

    column.addEventListener('drop', (e) => {
      e.preventDefault();
      column.classList.remove('is-drag-over');
      if (draggedCard) {
        column.appendChild(draggedCard);
        updateColumnCounts();
        if (typeof showToast === 'function') {
          const colName = column.closest('.kanban-column').querySelector('.kanban-column__title').textContent.trim();
          showToast(`Task moved to <strong>${colName}</strong>`, 'success');
        }
      }
    });
  });
}

function updateColumnCounts() {
  const columns = document.querySelectorAll('.kanban-column');
  columns.forEach(col => {
    const countBadge = col.querySelector('.kanban-column__count');
    const cards = col.querySelectorAll('.kanban-card');
    if (countBadge) {
      countBadge.textContent = cards.length;
    }
  });
}

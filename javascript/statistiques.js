function updateStatistics() {
    const statisticsContainer = document.querySelector('.statistiques ul');
    const tableRows = document.querySelectorAll('.liste-taches table tbody tr');
    let pendingCount = 0;
    let inProgressCount = 0;
    let completedCount = 0;

    tableRows.forEach(row => {
        const status = row.querySelector('td:nth-child(4)').textContent.trim();
        switch (status) {
            case 'pending':
                pendingCount++;
                break;
            case 'in_progress':
                inProgressCount++;
                break;
            case 'completed':
                completedCount++;
                break;
            default:
                break;
        }
    });

    const totalCount = tableRows.length;
    const todoCount = pendingCount;

    statisticsContainer.innerHTML = `
        <li>Nombre total de tâches: ${totalCount}</li>
        <li>Tâches en cours: ${inProgressCount}</li>
        <li>Tâches terminées: ${completedCount}</li>
        <li>Tâches à faire: ${todoCount}</li>
    `;
}
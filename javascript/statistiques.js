function updateStatistics() {
    const statisticsContainer = document.querySelector('.statistiques ul');
    const tableRows = document.querySelectorAll('.liste-taches table tbody tr');
    let pending = 0;
    let inProgress = 0;
    let completed = 0;

    tableRows.forEach(row => {
        const status = row.querySelector('td:nth-child(4)').textContent.trim();
        switch (status) {
            case 'pending':
                pending++;
                break;
            case 'in_progress':
                inProgress++;
                break;
            case 'completed':
                completed++;
                break;
            default:
                break;
        }
    });

    const totalCount = tableRows.length;
    const todoCount = pending;

    statisticsContainer.innerHTML = `
        <li>Nombre total de tâches: ${totalCount}</li>
        <li>Tâches en cours: ${inProgress}</li>
        <li>Tâches terminées: ${completed}</li>
        <li>Tâches à faire: ${todoCount}</li>
    `;
}
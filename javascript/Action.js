document.addEventListener('DOMContentLoaded', function () {
    const filterButton = document.querySelector('.section-filtres button');
    filterButton.addEventListener('click', applyFilter);

    // Fonction pour appliquer le filtrage
    function applyFilter() {
        const statusSelect = document.getElementById('statut2');
        const assignedInput = document.getElementById('assigne');
        const tableRows = document.querySelectorAll('.liste-taches table tbody tr');

        const selectedStatus = statusSelect.value;
        const assignedTo = assignedInput.value.trim().toLowerCase();

        tableRows.forEach(row => {
            const rowStatus = row.querySelector('td:nth-child(4)').textContent.trim().toLowerCase();
            const rowAssignedTo = row.querySelector('td:nth-child(5)').textContent.trim().toLowerCase();

            const statusMatch = selectedStatus === '' || rowStatus === selectedStatus;
            const assignedToMatch = assignedTo === '' || rowAssignedTo.includes(assignedTo);

            if (statusMatch && assignedToMatch) {
                row.style.display = ''; // Afficher la ligne si les critères de filtrage correspondent
            } else {
                row.style.display = 'none'; // Masquer la ligne si les critères de filtrage ne correspondent pas
            }
        });
    }
});
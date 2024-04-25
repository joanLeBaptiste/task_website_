function tableau2(){
    const tableBody = document.querySelector('.liste-taches table tbody');

    fetch('../pages/createdTask.php')
        .then(response => response.json()) // Transforme la réponse en JSON
        .then(data => {
            data.forEach(task => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${task.title}</td>
                    <td>${task.description}</td>
                    <td>${task.status}</td>
                    <td>${task.assigned_to}</td>
                    <td>${task.created_by}</td>
                    <td>${task.created_at}</td>
                    <td>Actions</td>
                  `;

                tableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données :', error);
        });
}
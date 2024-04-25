// script.js
function handleActionClick(event) {
    // Récupérer l'ID de la tâche
    const taskId = event.target.closest('tr').getAttribute('data-task-id');
    console.log(taskId);
    // Créer le formulaire
    const form = document.createElement('form');
    form.innerHTML = `
        <label for="status">Statut:</label>
        <select id="status">
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>
        <button id="submitBtn" onclick="submitStatus(${taskId})">Valider</button>
    `;

    // Ajouter le formulaire à l'endroit désiré dans le DOM
    const container = document.querySelector('.liste-taches');
    container.appendChild(form);
}

function submitStatus(taskId) {
    const selectedStatus = document.getElementById('status').value;

    fetch('../pages/updateStatut.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ taskId: taskId, status: selectedStatus })
    })
        .then(response => {
            // Gérer la réponse du serveur
            if (response.ok) {
                console.log('Statut mis à jour avec succès');
                // Fermer le formulaire ou effectuer d'autres actions
            } else {
                console.error('Erreur lors de la mise à jour du statut');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
}



function tableau() {
    const tableBody = document.querySelector('.liste-taches table tbody');

    fetch('../pages/mytask.php')
        .then(response => response.json()) // Transforme la réponse en JSON
        .then(data => {
            data.forEach(task => {
                const row = document.createElement('tr');

                row.innerHTML = `
                      <td>${task.id}</td>
                      <td>${task.title}</td>
                      <td>${task.description}</td>
                      <td>${task.status}</td>
                      <td>${task.assigned_to}</td>
                      <td>${task.created_by}</td>
                      <td>${task.created_at}</td>
                      <td><button class="action-button">modifier statut</button></td>
                    `;

                // Ajouter un attribut data-task-id pour stocker l'ID de la tâche dans la ligne
                row.setAttribute('data-task-id', task.id);

                // Ajouter un gestionnaire d'événements clic au bouton "Actions"
                const actionButton = row.querySelector('.action-button');
                actionButton.addEventListener('click', handleActionClick);

                tableBody.appendChild(row);

            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données :', error);
        });
}



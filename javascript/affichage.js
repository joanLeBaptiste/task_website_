function recupClick(event) {
    const taskId = event.target.closest('tr').getAttribute('data-task-id');
    console.log(taskId);
    const form = document.createElement('form');
    form.innerHTML = `
        <label for="status">Statut:</label>
        <select id="status">
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>
        <button id="submitBtn" onclick="envoieStatut(${taskId})">Valider</button>
    `;

    const container = document.querySelector('.liste-taches');
    container.appendChild(form);
}

function envoieStatut(taskId) {
    const selectedStatus = document.getElementById('status').value;

    fetch('../pages/updateStatut.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ taskId: taskId, status: selectedStatus })
    })
        .then(response => {
            if (response.ok) {
                console.log('Statut mis à jour ');
            } else {
                console.error('Erreur lors de mise à jour du statut');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
}



function tableau() {
    const tableBody = document.querySelector('.liste-taches table tbody');
    fetch('../pages/mytask.php')
        .then(response => response.json())
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

                row.setAttribute('data-task-id', task.id);

                const actionButton = row.querySelector('.action-button');
                actionButton.addEventListener('click', recupClick);

                tableBody.appendChild(row);

            });
        })
        .catch(error => {
            console.error('Erreur lors de récupération des données :', error);
        });
}



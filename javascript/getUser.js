function fetchUserNames() {
    fetch('../pages/getUserID&name.php')
        .then(response => response.json())
        .then(data => {
            const selectElement = document.getElementById('assigne_a');
            selectElement.innerHTML = '';

            data.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id; // Utilisez l'ID de l'utilisateur comme valeur
                option.textContent = user.name; // Utilisez le nom de l'utilisateur comme texte de l'option
                selectElement.appendChild(option);
            });
        })
        .catch(error => console.error('Erreur lors de la récupération des noms d\'utilisateur :', error));
}

// Appelez la fonction pour récupérer les noms d'utilisateur lors du chargement de la page

function parcourUserName() {
    fetch('../pages/getUserID&name.php')
        .then(response => response.json())
        .then(data => {
            const selectElement = document.getElementById('assigne_a');
            selectElement.innerHTML = '';

            data.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.name;
                selectElement.appendChild(option);
            });
        })
        .catch(error => console.error('Erreur lors de la récupération des noms d\'utilisateur :', error));
}


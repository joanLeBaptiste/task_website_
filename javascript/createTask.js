function creerTache() {

    const formData = new FormData(document.getElementById('formulaire-creer-tache'));
    console.log(formData);
    // Envoi des données au serveur avec fetch
    fetch('../pages/newtask.php', {
        method: 'POST',
        body: formData // Utilisation directe de FormData
    })
        .then(response => response.json())
        .then(data => {
            // Traitement de la réponse du serveur
            console.log(data);
            alert(data);
            window.location.reload();
        })
        .catch(error => console.error('Erreur lors de la création de la tâche :', error));
}
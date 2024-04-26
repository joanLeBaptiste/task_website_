function creerTache() {

    const formData = new FormData(document.getElementById('formulaire-creer-tache'));
    console.log(formData);
    fetch('../pages/newtask.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            alert(data);
            window.location.reload();
        })
        .catch(error => console.error('Erreur lors de création de la tâche :', error));
}
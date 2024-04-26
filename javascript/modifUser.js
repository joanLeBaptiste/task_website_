function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function modifUser() {
    var UPusername = document.getElementById('UPusername').value;
    var UPemail = document.getElementById('UPemail').value;
    var UPpassword = document.getElementById('UPassword').value;

    var userData = {
        UPusername: UPusername,
        UPemail: UPemail,
        UPpassword: UPpassword
    };
    console.log(userData);

    // Créer une requête AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/Projet_S4_restapi/pages/update_user.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Traitement de la réponse du serveur
                var response = JSON.parse(xhr.responseText);
                // Afficher un message à l'utilisateur
                document.getElementById('response').innerHTML = "<div class='alert alert-success'>informations mise à jour</div>";
            } else {
                // Gérer les erreurs
                document.getElementById('response').innerHTML = "<div class='alert alert-danger'>impossible de mettre à jour</div>";
                if (xhr.status === 401) {
                    showLoginPage();
                    document.getElementById('response').innerHTML = "<div class='alert alert-success'>sessions expiré, reconnectez-vous</div>";
                }
            }
        }
    };

    // Envoyer les données JSON
    xhr.send(JSON.stringify(userData));

    return false;
}
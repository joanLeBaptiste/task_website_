<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Gestion de Tâches</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <div class="container">
        <h1>Système de Gestion de Tâches</h1>
        <nav>
            <ul>
                <li><a href="../templates/pagesindex.php">Accueil</a></li>
                <li><a href="../templates/pagesLogin.php">connexion</a></li>
            </ul>
        </nav>
    </div>
</header>


<!--

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Gestion de Tâches</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        // Fonction pour supprimer le cookie JWT lors de la déconnexion
        function deleteJwtCookie() {
            document.cookie = "jwt=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        }

        // Fonction pour obtenir la valeur d'un cookie par son nom
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

        // Fonction pour envoyer les données au serveur
        function updateUser() {
            // Récupérer les données à partir des champs du formulaire
            var userData = {
                username: document.getElementById('UPusername').value,
                email: document.getElementById('UPemail').value,
                password: document.getElementById('UPpassword').value
            };

            // Récupérer le jeton JWT du cookie
            var jwtToken = getCookie('jwt');

            // Créer une requête AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../pages/update_user.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Traitement de la réponse du serveur
                        var response = JSON.parse(xhr.responseText);
                        alert(response.message); // Afficher un message à l'utilisateur
                    } else {
                        // Gérer les erreurs
                        alert("Une erreur s'est produite lors de la mise à jour de l'utilisateur.");
                    }
                }
            };

            // Envoyer les données JSON avec le jeton JWT dans l'en-tête Authorization
            xhr.setRequestHeader("Authorization", "Bearer " + jwtToken);
            xhr.send(JSON.stringify(userData));
        }
    </script>
</head>
<body>
<header>
    <div class="container">
        <h1>Système de Gestion de Tâches</h1>
        <nav>
            <ul>
                <li><a href="../templates/pagesindex.php">Accueil</a></li>
                <li><a href="../pages/dashboard.php">Tableau de bord</a></li>
                <li><a href="../pages/logout.php">Déconnexion</a></li>
                <li><a href="../templates/pagesLogin.php">connexion</a></li>
            </ul>
        </nav>
    </div>
</header>
<div class="container">
    <h2>Modifier Utilisateur</h2>
    <form id="updateUserForm">
        <div class="form-group">
            <label>Nom d'utilisateur</label>
            <input type="text" id="UPusername">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" id="UPemail">
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" id="UPpassword">
        </div>
        <div class="form-group">
            <button type="button" onclick="updateUser()">Mettre à jour</button>
        </div>
    </form>
</div>
-->
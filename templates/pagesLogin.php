<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Gestion de Tâches - Connexion</title>
    <link rel="stylesheet" href="../css/style.css">

    <script>
        // La fonction setCookie() que vous souhaitez intégrer
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function send() {
            document.getElementById("submitButton").disabled = true;
            // Récupérer les données du formulaire
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Créer un objet représentant les données de l'utilisateur
            const user = { email: email, password: password };

            // Convertir l'objet en chaîne JSON
            const body = JSON.stringify(user);

            // Envoyer les données au serveur via fetch
            fetch("../pages/login.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: body
            })
                .then(response => {
                    // Vérifier si la réponse est OK
                    if (response.ok) {
                        // Extraire les données JSON de la réponse
                        return response.json();
                    } else {
                        // Si la réponse n'est pas OK, rejeter la promesse avec une erreur
                        throw new Error(`Erreur HTTP ${response.status}`);
                    }
                })
                .then(data => {
                    // Traiter les données reçues
                    const token = data.jwt;
                    const message = data.message;
                    console.log("Token: " + token+ "message"+message);
                    alert(message+token);
                    // Créer le cookie JWT
                    const now = new Date();
                    const expires = new Date(now.getTime() + 3600000); // 1 heure en millisecondes
                    setCookie('jwt', token, 1);
                    console.log("Cookie: " + document.cookie);
                    // Rediriger l'utilisateur vers dashboard.php
                    window.location.href = "dashboard.php";
                })
                .catch(error => {
                    // Gérer les erreurs
                    console.error("Erreur lors de la requête fetch:", error);
                    alert(`Erreur lors de la connexion: ${error.message}`);
                });
        }

    </script>
</head>
<body>

<?php include('../partials/header.php'); ?>

<div class="container">
    <h2>Connexion</h2>
    <p>Veuillez remplir vos informations de connexion.</p>
    <form id="loginForm">
        <div class="form-group">
            <label>Nom d'utilisateur</label>
            <input type="text" name="email" id="email">
            <span class="help-block" id="usernameErr"></span>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" id="password">
            <span class="help-block" id="passwordErr"></span>
        </div>
        <div class="form-group">
            <button type="button" onclick="send()" id="submitButton">Se connecter</button>
        </div>
        <p>Vous n'avez pas de compte? <a href="../templates/pageSignup.php">Inscrivez-vous ici</a>.</p>
    </form>
</div>
<!--
<h2>Token de l'user: </h2>
<textarea id="userToken" rows="4" cols="50"></textarea> -->



<?php include('../partials/footer.php'); ?>



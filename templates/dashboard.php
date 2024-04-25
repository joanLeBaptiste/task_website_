<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord des tâches</title>
    <!-- <link rel="stylesheet" href="../css/dashboard.css"> -->
    <script src="../javascript/script.js"></script>
    <script src="../javascript/createTask.js"></script>
    <script src="../javascript/getUser.js"></script>
    <script src="../javascript/createdTask.js"></script>



    <style>
        /* Style global */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #333;
            color: #fff;
            padding: 1em 0;
            position: relative;
        }

        h1 {
            margin: 0; /* Réinitialiser la marge pour centrer le titre */
        }

        #ouvrir-formulaire {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .container_principale {
            display: flex;
            align-items: center;
        }

        #form-modifier {
            display: none;
        }

        aside {
            float: left;
            width: 200px;
            background-color: #f0f0f0;
            padding: 1em;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav li {
            margin-bottom: 1em;
        }

        nav a {
            display: block;
            padding: 0.5em 1em;
            text-decoration: none;
            color: #333;
        }

        nav a:hover {
            background-color: #eee;
        }

        nav li.active a {
            background-color: #555;
            color: #fff;
        }

        main {
            margin-left: 220px;
            padding: 1em;
            margin-bottom: 50px;
        }

        section {
            margin-bottom: 2em;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 1em;
        }

        .section-active {
            background-color: #f5f5f5;
        }

        .section-filtres, .section-taches {
            border: 1px solid #ddd;
            padding: 1em;
        }

        .statistiques ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .statistiques li {
            margin-bottom: 0.5em;
        }

        .liste-taches table {
            width: 100%;
            border-collapse: collapse;
        }

        .liste-taches th, .liste-taches td {
            border: 1px solid #ddd;
            padding: 0.5em;
            text-align: left;
        }

        .liste-taches th {
            background-color: #f0f0f0;
        }

        .liste-taches a {
            text-decoration: none;
            color: #333;
        }

        .liste-taches a:hover {
            color: #007bff;
        }

    </style>
    <script>
        function ouvrirFormulaire(form) {
            var formModifier = document.getElementById(form);
            if (formModifier.style.display === 'block') {
                formModifier.style.display = 'none';
            } else {
                formModifier.style.display = 'block';
            }
        }


        // Fonction pour récupérer le cookie
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
        function updateUser() {
            // Récupérer les valeurs des champs du formulaire
            var UPusername = document.getElementById('UPusername').value;
            var UPemail = document.getElementById('UPemail').value;
            var UPpassword = document.getElementById('UPassword').value;

            // Créer un objet JSON avec les données
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
                        document.getElementById('response').innerHTML = "<div class='alert alert-success'>Account was updated.</div>";
                    } else {
                        // Gérer les erreurs
                        document.getElementById('response').innerHTML = "<div class='alert alert-danger'>Unable to update account.</div>";
                        if (xhr.status === 401) {
                            showLoginPage();
                            document.getElementById('response').innerHTML = "<div class='alert alert-success'>Access denied. Please login</div>";
                        }
                    }
                }
            };

            // Envoyer les données JSON
            xhr.send(JSON.stringify(userData));

            return false;
        }

    </script>
</head>
<body>
<header>
    <div class="container_principale">
        <h1>Tableau de bord des tâches</h1>
        <button id="ouvrir-formulaire" class="bouton-modifier" onclick="ouvrirFormulaire('form-modifier')">Update</button>
        <div id="form-modifier" style="display:none;">
            <form id="update-form">
                <label for="UPusername">Nom d'utilisateur:</label>
                <input type="text" id="UPusername" required><br>
                <label for="UPemail">Email:</label>
                <input type="email" id="UPemail" required><br>
                <label for="UPassword">Mot de passe:</label>
                <input type="password" id="UPassword" required><br>
                <button type="button" onclick="updateUser()">Envoyer</button>
            </form>
        </div>
        <div id="response"></div>
    </div>
</header>
<aside>

    <section class="section-active">
        <h2>Tableau de bord</h2>
        <ul>
            <li><button onclick="fetchUserNames();ouvrirFormulaire('form-creer-tache')">Creer une tache</button></li>
            <li><button onclick="tableau2()">tache crée</button></li>
            <li><button onclick="tableau()">mes taches</button></li>
        </ul>
        <div id="form-creer-tache" style="display: none;">
            <form id="formulaire-creer-tache">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre"><br><br>
                <label for="description">Description :</label>
                <input type="text" id="description" name="description"><br><br>
                <label for="statut">Statut :</label>
                <select id="statut" name="statut">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select><br><br>
                <label for="assigne_a">Assigné à :</label>
                <select id="assigne_a" name="assigne_a">
                    <!-- dynamique -->
                </select><br><br>
                <button type="button" onclick="creerTache()">créer</button>
            </form>
        </div>
    </section>

    <div class="statistiques">
        <h2>Statistiques</h2>
        <ul>
            <li>Nombre total de tâches: 3</li>
            <li>Tâches en cours: 1</li>
            <li>Tâches terminées: 1</li>
            <li>Tâches à faire: 1</li>
        </ul>
    </div>

</aside>

<main>


    <section class="section-filtres">
        <h2>Filtres</h2>
        <form>
            <label for="statut2">Statut:</label>
            <select id="statut2">
                <option value="">Tous</option>
                <option value="en-cours">En cours</option>
                <option value="terminee">Terminée</option>
                <option value="a-faire">À faire</option>
            </select>

            <label for="assigne">Assigné à:</label>
            <input type="text" id="assigne">

            <button type="submit">Filtrer</button>
        </form>
    </section>

    <section class="section-taches">
        <div class="liste-taches">
            <h2>tableau des tâches</h2>
            <table>
                <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Statut</th>
                    <th>Assigné à</th>
                    <th>crée par</th>
                    <th>date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </section>
</main>


<?php include('../partials/footer.php'); ?>





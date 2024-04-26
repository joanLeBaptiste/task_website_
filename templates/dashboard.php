<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord des tâches</title>
     <link rel="stylesheet" href="../css/dashboard.css">
    <script src="../javascript/Action.js"></script>
    <script src="../javascript/affichage.js"></script>
    <script src="../javascript/creerTask.js"></script>
    <script src="../javascript/recupUser.js"></script>
    <script src="../javascript/afficherTask.js"></script>
    <script src="../javascript/statistiques.js"></script>
    <script src="../javascript/modifUser.js"></script>


    <style>
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
    </script>

</head>
<body>
    <header>
        <div class="container_principale">
            <h1>Tableau de bord des tâches</h1>
            <button id="ouvrir-formulaire" class="bouton-modifier" onclick="ouvrirFormulaire('form-modifier')">changer ses informations</button>
            <div id="form-modifier" style="display:none;">
                <form id="update-form">
                    <label for="UPusername">Nom d'utilisateur:</label>
                    <input type="text" id="UPusername" required><br>
                    <label for="UPemail">Email:</label>
                    <input type="email" id="UPemail" required><br>
                    <label for="UPassword">Mot de passe:</label>
                    <input type="password" id="UPassword" required><br>
                    <button type="button" onclick="modifUser()">Envoyer</button>
                </form>
            </div>
            <div id="response"></div>
        </div>
    </header>
    <aside>

        <section class="section-active">
            <h2>Tableau de bord</h2>
            <ul>
                <li><button onclick="parcourUserName();ouvrirFormulaire('form-creer-tache');">Creer une tache</button></li>
                <li><button onclick="tableauCreated();">tache crée</button></li>
                <li><button onclick="tableau();">mes taches</button></li>
                <li><button onclick="location.reload();">rafraîchir</button></li>
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
                <li>Nombre total de tâches:</li>
                <li>Tâches en cours: </li>
                <li>Tâches terminées: </li>
                <li>Tâches à faire: </li>
            </ul>
            <button type="button" onclick="updateStatistics();">afficher statistiques</button>

        </div>

    </aside>

    <main>
        <section class="section-filtres" style="display: flex; flex-direction: column;">
            <h2>Filtres</h2>
            <div class="filtre-container" style="display: flex; align-items: center;">
                <div style="margin-right: 10px;">
                    <label for="statut2">Statut:</label>
                    <select id="statut2">
                        <option value="">Tous</option>
                        <option value="in_progress">in_progress</option>
                        <option value="pending">pending</option>
                        <option value="completed">completed</option>
                    </select>
                </div>

                <div style="margin-right: 10px;">
                    <label for="assigne">Assigné à:</label>
                    <input type="text" id="assigne">
                </div>

                <button id="filtrer">Filtrer</button>
            </div>
        </section>

        <section class="section-taches">
            <div class="liste-taches">
                <h2>tableau des tâches</h2>
                <table id="table-Tache">
                    <thead>
                    <tr>
                        <th>ID</th>
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


<?php include('../head-foot/footer.php'); ?>





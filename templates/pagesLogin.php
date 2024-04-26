<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Gestion de Tâches - Connexion</title>
    <link rel="stylesheet" href="../css/style.css">

    <script src="../javascript/connexion.js"></script>
</head>
<body>

<?php include('../head-foot/header.php'); ?>

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



<?php //include('../head-foot/footer.php'); ?>



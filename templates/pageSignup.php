<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Gestion de Tâches - Inscription</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('../partials/header.php'); ?>

<div class="container">
    <h2>Inscription</h2>
    <p>Veuillez remplir ce formulaire pour créer un compte.</p>
    <form id="registerForm">
        <div class="form-group">
            <label>Nom d'utilisateur</label>
            <input type="text" id="username">
            <span class="help-block"></span>
        </div>
        <div class="form-group">
            <label>Adresse E-mail</label>
            <input type="text" id="email">
            <span class="help-block"></span>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" id="password">
            <span class="help-block"></span>
        </div>
        <div class="form-group">
            <label>Confirmer le mot de passe</label>
            <input type="password" id="confirm_password">
            <span class="help-block"></span>
        </div>
        <div class="form-group">
            <button type="button" onclick="createUser()">S'inscrire</button>
            <button type="reset">Réinitialiser</button>
        </div>
        <p>Vous avez déjà un compte? <a href="../templates/pagesLogin.php">Connectez-vous ici</a>.</p>
    </form>
</div>

<?php include('../partials/footer.php'); ?>

<script>

    function createUser() {
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirm_password = document.getElementById('confirm_password').value;

        if (password !== confirm_password) {
            alert("Les mots de passe ne correspondent pas.");
            return;
        }

        const data = {
            username: username,
            email: email,
            password: password
        };

        fetch('../pages/signup.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                console.log(data);
                console.log(result.message);
                alert(result.message);
                window.location.href = "../templates/pagesLogin.php";
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

</script>

</body>
</html>

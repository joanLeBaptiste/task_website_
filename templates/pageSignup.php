
<?php include('../head-foot/header.php'); ?>

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
            <button type="button" onclick="creerUSer()">S'inscrire</button>
            <button type="reset">Réinitialiser</button>
        </div>
        <p>Vous avez déjà un compte? <a href="../templates/pagesLogin.php">Connectez-vous ici</a>.</p>
    </form>
</div>

<?php //include('../head-foot/footer.php'); ?>
<script src="../javascript/creerUser.js"></script>


</body>
</html>

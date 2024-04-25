<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../includes/config.php');
require_once('../objects/User.php');


$database = new Database();
$db = $database->getConnection();

// instantiate user object
$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set user property values
$user->username = $data->username;
$user->email = $data->email;
$user->password = $data->password;

// create the user
if (
    !empty($user->username) &&
    !empty($user->email) &&
    !empty($user->password) &&
    $user->create()
) {
    // set response code
    http_response_code(200);
    // display message: user was created
    echo json_encode(array("message" => "User was created."));
} else {
    // set response code
    http_response_code(400);
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
}




/*
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Nom d'utilisateur</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Adresse E-mail</label>
            <input type="text" name="email" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Mot de passe</label>
            <input type="password" name="password" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirmer le mot de passe</label>
            <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <button type="submit">S'inscrire</button>
            <button type="reset">Réinitialiser</button>
        </div>
        <p>Vous avez déjà un compte? <a href="login.php">Connectez-vous ici</a>.</p>
    </form>
</div>

<?php include('../partials/footer.php'); ?>
</body>
</html>
*/
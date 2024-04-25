<?php
header("Content-Type: application/json; charset=UTF-8");
require_once('../includes/config.php');
require_once('../libs/JWT.php');
require_once ('../includes/core.php');
require_once ('../objects/User.php');
require_once ('../objects/Session.php');


$Session = new Session();
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jwt = $Session->getJwt();

    // Vérifier si un jeton JWT est présent
    if ($jwt) {
        try {
            // Décoder le jeton JWT en utilisant la classe JWT
            $payload = JWTLib\JWT::decode($jwt, $key, ['HS256']);
            //print_r($payload);
            // Extraire l'ID utilisateur du payload
            if (isset($payload->data->id)) {
                $id = $payload->data->id;
                // Supprimer la session de l'utilisateur de la base de données
                $query = "DELETE FROM user_sessions WHERE user_id = :id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id);
                if ($stmt->execute()) {
                    // Détruire la session actuelle
                    $Session->destroy();
                    $response['message'] = "Déconnexion réussie";
                } else {
                    $response['error'] = "Une erreur est survenue lors de la déconnexion";
                }
            } else {
                $response['error'] = "ID utilisateur non trouvé dans le jeton JWT";
            }
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }
    } else {
        $response['error'] = "Aucun jeton JWT trouvé";
    }

    echo json_encode($response);
    exit;
}




/*
header("Content-Type: application/json; charset=UTF-8");
require_once ('../objects/Session.php');
require_once('../includes/config.php');


$Session = new Session();
$database = new Database();
$conn = $database->getConnection();
//$id = $Session->get('user', 'id');
//var_dump("id: ".$id);
print_r($_SESSION);

if ($Session->get('user', 'id')) {
    // L'utilisateur est connecté, procédez à la déconnexion
    $id = $Session->get('user', 'id');

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $query = "DELETE FROM user_sessions WHERE user_id= :id";
        $stmt = $conn->prepare( $query );
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $Session->destroy();
            $response['message'] = "Déconnexion réussie pour l'utilisateur avec l'ID : $id";
        } else {
            $response['error'] = "Une erreur est survenue lors de la déconnexion pour l'utilisateur avec l'ID : $id";
        }
        echo json_encode($response);
        exit;
    }
} else {
    // L'utilisateur n'est pas connecté, renvoyez une erreur
    http_response_code(401); // Unauthorized
    echo json_encode(array("error" => "Utilisateur non connecté"));
    exit;
}

*/


/*
header("Access-Control-Allow-Origin: *");
require_once('../includes/config.php');
//require_once('../libs/JWT.php');
require_once ('../includes/core.php');
require_once ('../objects/User.php');
require_once ('../objects/Session.php');

$database = new Database();
$db = $database->getConnection();

// Initialiser la session
Session::start();

// Récupérer le JWT
$jwt = $_COOKIE['jwt'] ?? '';
//var_dump($jwt);

// Si le JWT est vide, renvoyer un message d'erreur
if (empty($jwt)) {
    http_response_code(400);
    echo json_encode(['message' => 'JWT manquant']);
    exit;
}
// Effectuez une demande POST à validate_token.php pour valider le JWT
$validate_response = file_get_contents('http://localhost/Projet_S4_restapi/objects/validate_token.php', false, stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode(array('jwt' => $jwt))
    )
)));

// Analysez la réponse
$validate_result = json_decode($validate_response, true);
if ($validate_result && isset($validate_result['message']) && $validate_result['message'] === 'Access granted.') {
    // Récupérer l'ID de l'utilisateur depuis la session
    $user_id = Session::get('users','id');

    // Si l'ID de l'utilisateur existe, supprimer l'entrée correspondante dans la base de données
    if ($user_id !== false) {
        $delete_session_query = "DELETE FROM user_sessions WHERE user_id = :user_id";
        $delete_session_stmt = $db->prepare($delete_session_query);
        $delete_session_stmt->bindParam(':user_id', $user_id);
        $delete_session_stmt->execute();
    }

    // Détruire la session côté serveur
    Session::destroy();

    // Répondre avec un message JSON
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Déconnexion réussie']);
} else {
    // Si le JWT n'est pas valide ou si la demande échoue, renvoyez un message d'erreur
    http_response_code(401);
    echo json_encode(['message' => 'JWT invalide ou demande échouée']);
}



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
</head>
<body>
<h2>Déconnexion</h2>
<!-- Formulaire pour déclencher la déconnexion -->
<form method="post">
    <button type="button" onclick="logout()">Se déconnecter</button>
</form>
</body>
<script>
    function logout() {
        localStorage.removeItem('jwt');
        display('');
        alert('Vous avez été déconnecté');
        window.location.href = "../templates/pagesLogin.php";
    }
</script>
</html>

*/





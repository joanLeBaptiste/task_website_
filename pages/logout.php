<?php
require_once('../includes/config.php');
require_once('../libs/JWT.php');
require_once ('../includes/core.php');
require_once ('../objects/User.php');
require_once ('../objects/Session.php');

// le but de ce fichier est de detruire la session et la session sauvegardée dans la BDD
$Session = new Session();
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jwt = $Session->getJwt();

    if ($jwt) {
        try {
            $payload = JWTLib\JWT::decode($jwt, $key, ['HS256']);

            if (isset($payload->data->id)) {
                $id = $payload->data->id;
                // destruuction dans la BDD
                $query = "DELETE FROM user_sessions WHERE user_id = :id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id);
                //reponse au JS
                if ($stmt->execute()) {
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









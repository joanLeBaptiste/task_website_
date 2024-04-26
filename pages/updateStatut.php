<?php
header("Content-Type: application/json; charset=UTF-8");
require_once('../includes/config.php');
require_once('../libs/JWT.php');
require_once ('../includes/core.php');
require_once ('../objects/User.php');
require_once ('../objects/Session.php');

//sessions avec la classe session
$Session = new Session();

$jwt = $Session->getJWT(); // test jwt
if (!$jwt) {
    http_response_code(401);
    echo json_encode(array("message" => "Non autorisé"));
    exit;
}

try {
    $payload = JWTLib\JWT::decode($jwt, $key, ['HS256']);
    if (isset($payload->data->id)) {
        $user_id = $payload->data->id;//recup ID

        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->taskId) && isset($data->status)) {// recup des element envoyé par le JS
            $database = new Database();
            $conn = $database->getConnection();

            $query = "UPDATE tasks SET status = :status WHERE id = :taskId AND created_by = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':status', $data->status); // on les rempli par les valeurs recup de la BDD
            $stmt->bindParam(':taskId', $data->taskId);
            $stmt->bindParam(':user_id', $user_id);
            //ENVOIE AU JS
            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(array("message" => "Statut mis à jour avec succès"));
            } else {
                http_response_code(500);
                echo json_encode(array("message" => "Erreur lors de la mise à jour du statut"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Données insuffisantes pour mettre à jour le statut"));
        }
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "ID utilisateur non trouvé dans le jeton JWT"));
    }
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(array("message" => $e->getMessage()));
}


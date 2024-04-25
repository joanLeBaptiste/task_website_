<?php
header("Content-Type: application/json; charset=UTF-8");
require_once('../includes/config.php');
require_once('../libs/JWT.php');
require_once ('../includes/core.php');
require_once ('../objects/User.php');
require_once ('../objects/Session.php');

$Session = new Session();

// Vérification de la présence d'un jeton JWT dans la session
$jwt = $Session->getJWT();
if (!$jwt) {
    // Si aucun jeton JWT n'est trouvé, renvoyer une réponse non autorisée
    http_response_code(401);
    echo json_encode(array("message" => "Non autorisé"));
    exit;
}

try {
    // Décodage du jeton JWT
    $payload = JWTLib\JWT::decode($jwt, $key, ['HS256']);
    // Vérification de l'ID utilisateur dans le payload
    if (isset($payload->data->id)) {
        // Récupération de l'ID utilisateur
        $user_id = $payload->data->id;

        // Récupération des données envoyées depuis le frontend
        $data = json_decode(file_get_contents("php://input"));

        // Vérification de l'existence des données nécessaires
        if (isset($data->taskId) && isset($data->status)) {
            // Connexion à la base de données
            $database = new Database();
            $conn = $database->getConnection();

            // Préparation de la requête SQL pour mettre à jour le statut de la tâche
            $query = "UPDATE tasks SET status = :status WHERE id = :taskId AND created_by = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':status', $data->status);
            $stmt->bindParam(':taskId', $data->taskId);
            $stmt->bindParam(':user_id', $user_id);

            // Exécution de la requête SQL
            if ($stmt->execute()) {
                // Envoi d'une réponse JSON avec un message de succès
                http_response_code(200);
                echo json_encode(array("message" => "Statut mis à jour avec succès"));
            } else {
                // Envoi d'une réponse JSON avec un message d'erreur
                http_response_code(500);
                echo json_encode(array("message" => "Erreur lors de la mise à jour du statut"));
            }
        } else {
            // Données insuffisantes envoyées depuis le frontend
            http_response_code(400);
            echo json_encode(array("message" => "Données insuffisantes pour mettre à jour le statut"));
        }
    } else {
        // ID utilisateur non trouvé dans le jeton JWT
        http_response_code(401);
        echo json_encode(array("message" => "ID utilisateur non trouvé dans le jeton JWT"));
    }
} catch (Exception $e) {
    // Erreur lors de la validation du jeton JWT
    http_response_code(401);
    echo json_encode(array("message" => $e->getMessage()));
}

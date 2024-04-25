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

        // Connexion à la base de données
        $database = new Database();
        $conn = $database->getConnection();

        // Requête SQL pour récupérer les tâches de l'utilisateur connecté avec les noms d'utilisateur correspondants
        $query = "SELECT 
                        t.*, 
                        ua.username AS assigned_to_username,
                        uc.username AS created_by_username
                  FROM 
                        tasks t
                  LEFT JOIN 
                        users ua ON t.assigned_to = ua.id
                  LEFT JOIN 
                        users uc ON t.created_by = uc.id
                  WHERE 
                        t.assigned_to = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Vérification s'il y a des tâches
        if ($stmt->rowCount() > 0) {
            $tasks_arr = array();

            // Parcours des lignes de résultat
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                // Formatage de la date
                $created_at = date("Y-m-d H:i:s", strtotime($created_at));

                // Construction de l'élément de tâche avec les noms d'utilisateur correspondants
                $task_item = array(
                    "id" => $id,
                    "title" => $title,
                    "description" => $description,
                    "status" => $status,
                    "assigned_to" => $assigned_to_username,
                    "created_by" => $created_by_username,
                    "created_at" => $created_at
                );

                // Ajout de l'élément de tâche à la liste
                array_push($tasks_arr, $task_item);
            }

            // Renvoi des données au format JSON
            http_response_code(200);
            echo json_encode($tasks_arr);
        } else {
            // Aucune tâche trouvée
            http_response_code(404);
            echo json_encode(array("message" => "Aucune tâche trouvée."));
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
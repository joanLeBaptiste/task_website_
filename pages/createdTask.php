<?php
header("Content-Type: application/json; charset=UTF-8");
require_once('../includes/config.php');
require_once('../libs/JWT.php');
require_once ('../includes/core.php');
require_once ('../objects/User.php');
require_once ('../objects/Session.php');

$Session = new Session();

$jwt = $Session->getJWT();
if (!$jwt) {
    http_response_code(401);
    echo json_encode(array("message" => "Non autorisé"));
    exit;
}

try {
    $payload = JWTLib\JWT::decode($jwt, $key, ['HS256']);
    if (isset($payload->data->id)) {
        $user_id = $payload->data->id;

        $database = new Database();
        $conn = $database->getConnection();
        // on recupère que l'user a cree dans la bdd
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
                        t.created_by = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $tasks_arr = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                $created_at = date("Y-m-d H:i:s", strtotime($created_at));
                //tableau simple pour le JS
                $task_item = array(
                    "id" => $id,
                    "title" => $title,
                    "description" => $description,
                    "status" => $status,
                    "assigned_to" => $assigned_to_username,
                    "created_by" => $created_by_username,
                    "created_at" => $created_at
                );

                array_push($tasks_arr, $task_item);
            }
            //envoie au JS
            http_response_code(200);
            echo json_encode($tasks_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Aucune tâche trouvée."));
        }
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "ID utilisateur non trouvé dans le jeton JWT"));
    }
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(array("message" => $e->getMessage()));
}



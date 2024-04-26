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
    $jwt = $Session->getJWT();

    if ($jwt) {
        try {
            $payload = JWTLib\JWT::decode($jwt, $key, ['HS256']);
            //filtrage des valeurs
            if (isset($payload->data->id)) {
                $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
                $statut = filter_input(INPUT_POST, 'statut', FILTER_SANITIZE_SPECIAL_CHARS);
                $assigne_a = filter_input(INPUT_POST, 'assigne_a', FILTER_SANITIZE_SPECIAL_CHARS);
                $id = $payload->data->id;//recup de l'id de qui est en train de creer la tache

                if (empty($titre) || empty($description) || empty($statut) || empty($assigne_a)) {
                    http_response_code(400);
                    echo json_encode(array("message" => "Veuillez remplir tous les champs du formulaire"));
                    exit;
                }

                $query = "INSERT INTO tasks (title, description, status, assigned_to, created_by) VALUES (:titre, :description, :statut, :assigne_a, :id)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':titre', $titre);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':statut', $statut);
                $stmt->bindParam(':assigne_a', $assigne_a);
                $stmt->bindParam(':id', $id);
                // reponse au JS
                if ($stmt->execute()) {
                    http_response_code(201);
                    echo json_encode(array("message sql " => "Tâche créée avec succès"));
                    exit;
                } else {
                    http_response_code(500);
                    echo json_encode(array("message sql" => "Erreur lors de la création de la tâche"));
                    exit;
                }
            } else {
                http_response_code(401);
                echo json_encode(array("message" => "Non autorisé"));
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array("error" => $e->getMessage()));
            exit;
        }
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Non autorisé"));
        exit;
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Méthode non autorisée"));
    exit;
}

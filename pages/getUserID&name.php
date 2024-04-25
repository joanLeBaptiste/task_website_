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

$database = new Database();
$conn = $database->getConnection();
$query = "SELECT id, username FROM users"; // Suppose que vous avez une table "users" avec des colonnes "id" et "name"
$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Création d'un tableau associatif pour stocker les données à envoyer
$donnees = array();
foreach ($users as $user) {
    $donnees[] = array(
        "id" => $user['id'],
        "name" => $user['username']
    );
}

// Envoi des données au format JSON
echo json_encode($donnees);


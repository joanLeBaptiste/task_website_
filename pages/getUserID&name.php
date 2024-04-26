<?php
header("Content-Type: application/json; charset=UTF-8");
require_once('../includes/config.php');
require_once('../libs/JWT.php');
require_once ('../includes/core.php');
require_once ('../objects/User.php');
require_once ('../objects/Session.php');

//ce code permet juste de recuperer les users de la BDD, pour pouvoir faire un select entre eux lors
//de la création d'une tâche
$Session = new Session();

$jwt = $Session->getJWT();
if (!$jwt) {
    http_response_code(401);
    echo json_encode(array("message" => "Non autorisé"));
    exit;
}

$database = new Database();
$conn = $database->getConnection();
$query = "SELECT id, username FROM users";
$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//envoie tableau au JS
$donnees = array();
foreach ($users as $user) {
    $donnees[] = array(
        "id" => $user['id'],
        "name" => $user['username']
    );
}

echo json_encode($donnees);



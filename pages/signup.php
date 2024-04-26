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

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->username = $data->username;
$user->email = $data->email;
$user->password = $data->password;
// creation d'un user avec les info reçu, on doit se connecter pour acceder au dashboard
if (
    !empty($user->username) &&
    !empty($user->email) &&
    !empty($user->password) &&
    $user->create()
) {// reponse au JS
    http_response_code(200);
    echo json_encode(array("message" => "User was created."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create user."));
}



<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../includes/config.php');
require_once('../libs/JWT.php');
require_once ('../includes/core.php');
require_once ('../objects/User.php');
require_once ('../objects/Session.php');
use \JWTLib\JWT;

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$Session = new Session();

$data = json_decode(file_get_contents("php://input"));

$user->email = $data->email;
//creation du jeton jwt, dure 1h
if($user->emailExists() && password_verify($data->password, $user->password)){
    $token = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "iss" => $issuer,
        "data" => array(
            "id" => $user->id,
            "firstname" => $user->username,
            "email" => $user->email
        )
    );

    http_response_code(200);

    $jwt = JWT::encode($token, $key);
    // on va inserer la session active dans la BDD
    $expiry_time = date('Y-m-d H:i:s', $expiration_time);
    $user_session_query = "INSERT INTO user_sessions (user_id, token, expiry_time) VALUES (:user_id, :token, :expiry_time)";
    $user_session_stmt = $db->prepare($user_session_query);
    $user_session_stmt->bindParam(':user_id', $user->id);
    $user_session_stmt->bindParam(':token', $jwt);
    $user_session_stmt->bindParam(':expiry_time', $expiry_time);
    if ($user_session_stmt->execute()) {
        $Session->set('id', $user->id);
        $Session->set('email', $user->email);
        $Session->setJWT($jwt);
        //reponse au JS
        echo json_encode(
            array(
                "message" => "login reussi, jwt:  ",
                "jwt" => $jwt
            )
        );
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error inserting session data."));
    }
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Login failed.",
        "email_exists" => $user->emailExists(),
        "db_PWD" =>$user->password,
        "data_PWD" => $data->password));
}

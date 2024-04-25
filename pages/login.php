<?php
// required headers
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

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate user object
$user = new User($db);
$Session = new Session();

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$user->email = $data->email;
//$email_exists = 0;

// check if email exists and if password is correct
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
    // set response code
    http_response_code(200);
    // generate jwt
    $jwt = JWT::encode($token, $key);

    $expiry_time = date('Y-m-d H:i:s', $expiration_time);
    $user_session_query = "INSERT INTO user_sessions (user_id, token, expiry_time) VALUES (:user_id, :token, :expiry_time)";
    $user_session_stmt = $db->prepare($user_session_query);
    $user_session_stmt->bindParam(':user_id', $user->id);
    $user_session_stmt->bindParam(':token', $jwt);
    $user_session_stmt->bindParam(':expiry_time', $expiry_time);
    if ($user_session_stmt->execute()) {
        // Stocker des informations de session dans la session PHP
        $Session->set('id', $user->id);
        $Session->set('email', $user->email);
        $Session->setJWT($jwt);
        //print_r($_SESSION);
        //session_regenerate_id();

        echo json_encode(
            array(
                "message" => $user->email." puis:".$data->email."ensuite :",//Session::get('users', "email"),
                "jwt" => $jwt
            )
        );
    } else {
        // Erreur lors de l'insertion dans la base de données
        http_response_code(500);
        echo json_encode(array("message" => "Error inserting session data."));
    }
} else {
    // set response code
    http_response_code(401);
    // tell the user login failed
    echo json_encode(array("message" => "Login failed.",
        "email_exists" => $user->emailExists(),
        "db_PWD" =>$user->password,
        "data_PWD" => $data->password));
}



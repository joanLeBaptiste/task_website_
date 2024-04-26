<?php
require_once ('../objects/Session.php');

$Session = new Session();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../includes/core.php';
include_once '../libs/JWT.php';

use \JWTLib\JWT;

include_once '../includes/config.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$jwt = $Session->getJWT();

if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        $user->username = $data->UPusername;
        $user->email = $data->UPemail;
        $user->password = $data->UPpassword;
        $user->id = $decoded->data->id;
        // on cree un nouveau jwt avec les nouvelle informations
        if ($user->update()) {
            $token = array(
                "iat" => $issued_at,
                "exp" => $expiration_time,
                "iss" => $issuer,
                "data" => array(
                    "id" => $user->id,
                    "username" => $user->username,
                    "email" => $user->email
                )
            );
            $jwt = JWT::encode($token, $key, $alg = 'HS256');
            // reponse au JS
            http_response_code(200);

            echo json_encode(
                array(
                    "message" => "User was updated."
                )
            );
        } else {
            http_response_code(401);

            echo json_encode(array("message" => "Unable to update user."));
        }
    } catch (Exception $e) {
        http_response_code(401);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
} else {
    http_response_code(401);

    echo json_encode(array("message" => "Access denied."));
}

<?php
require_once ('../objects/Session.php');

$Session = new Session();
$Session->start();

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// required to encode json web token
include_once '../includes/core.php';
include_once '../libs/JWT.php';

use \JWTLib\JWT;

// files needed to connect to database
include_once '../includes/config.php';
include_once '../objects/user.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate user object
$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// get jwt
$jwt = $Session->getJWT();
// if jwt is not empty
if ($jwt) {

    // if decode succeed, show user details
    try {

        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        // set user property values
        $user->username = $data->UPusername;
        $user->email = $data->UPemail;
        $user->password = $data->UPpassword;
        $user->id = $decoded->data->id;
       // print_r($username);
        //print_r($user->id);

        //print_r($email);
        //print_r($password);




// update the user record
        if ($user->update()) {
            // we need to re-generate jwt because user details might be different
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

            // set response code
            http_response_code(200);

            // response in json format
            echo json_encode(
                array(
                    "message" => "User was updated."
                )
            );
        } // message if unable to update user
        else {
            // set response code
            http_response_code(401);

            // show error message
            echo json_encode(array("message" => "Unable to update user."));
        }
    } // if decode fails, it means jwt is invalid
    catch (Exception $e) {

        // set response code
        http_response_code(401);

        // show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
} // show error message if jwt is empty
else {

    // set response code
    http_response_code(401);

    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}
?>
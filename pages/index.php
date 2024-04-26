<?php
require_once('../includes/config.php');
// ce code ne sert à rien
session_start();

include_once '../libs/JWT.php';
use \JWTLib\JWT;

$key = "votre_cle_secrete";

$jwt = $_COOKIE['jwt'] ?? '';

if($jwt){
    try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        header("location: dashboard.php");
        exit;
    } catch (Exception $e){

    }
}




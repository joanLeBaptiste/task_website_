<?php
// Inclusion du fichier de configuration pour la connexion à la base de données
require_once('../includes/config.php');

// Vérification de l'authentification de l'utilisateur
session_start();

// Vérification du JWT
include_once '../libs/JWT.php';
use \JWTLib\JWT;

// Clé secrète pour signer le JWT (à remplacer par votre propre clé secrète)
$key = "votre_cle_secrete";

// Récupération du JWT depuis le cookie
$jwt = $_COOKIE['jwt'] ?? '';

if($jwt){
    try {
        // Vérifier le JWT
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        // Le JWT est valide, rediriger l'utilisateur vers le tableau de bord
        header("location: dashboard.php");
        exit;
    } catch (Exception $e){
        // Le JWT est invalide, continuer vers la page d'accueil
    }
}

?>



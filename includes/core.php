<?php
//fichier core.php

error_reporting(E_ALL);
 
date_default_timezone_set('Europe/Paris');
 
$key = "12345";//à changer avec votre clé
$issued_at = time();
$expiration_time = $issued_at + (60 * 60);
$issuer = "http://localhost/Projet_S4_restapi/";//à changer avec votre url
?>
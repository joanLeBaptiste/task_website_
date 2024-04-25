<?php
class Session {

    public function __construct() {
        session_start();
    }

    public static function set($key, $value) {
        $_SESSION['users'][$key] = $value;
    }

    public static function setJWT($value) {
        $_SESSION['JWT'] = $value;
    }

    public static function get($key, $key2) {
        return isset($_SESSION[$key][$key2]) ? $_SESSION[$key][$key2] : false;
    }

    public static function getJWT() {
        return isset($_SESSION['JWT']) ? $_SESSION['JWT'] : false;
    }
    public static function getUserID() {
        return isset($_SESSION['users']['id']) ? $_SESSION['users']['id'] : false;
    }


    public static function destroy() {
        unset($_SESSION);
        session_destroy();
    }


}
?>
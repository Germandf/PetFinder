<?php

class AuthHelper {

    public function __construct() {
        // Si no hay una sesion iniciada, la inicia
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Obtiene el id del usuario
    public function getUserId(){
        if(isset($_SESSION['ID_USER'])){
            return $_SESSION['ID_USER'];
        }
        return 0;
    }

    // Consulta si el usuario esta logeado
    function isAuth(){
        if(isset($_SESSION['ID_USER'])){
            return true;
        }
        return false;
    }

    // Consulta si el usuario es admin
    function isAdmin(){
        if(isset($_SESSION['PERMISSION_USER'])){
            return ($_SESSION['PERMISSION_USER'] == 1);
        }
        return false;
    }

    public function redirectLogin(){
        header("Location: login");
    }

    function redirectHome(){
        header("Location: " . BASE_URL);
    }
}
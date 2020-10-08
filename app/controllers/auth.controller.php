<?php

include_once 'app/views/auth.view.php';
include_once 'app/models/user.model.php';

class AuthController {
    function __construct() {
        $this->view = new AuthView();
        $this->userModel = new UserModel();
    }
    function showLoginForm($err = null) {
        if($this->isAuth()){
            $this->redirectHome();
            die();
        }
        $this->view->showLoginForm($err);
    }
    function redirectHome(){
        header("Location: home");

    }
    function isAuth(){
        session_start();
        if(isset($_SESSION['ID_USER'])){
            return true;
        }
        return false;
    }
    public function logOut(){
        session_start();
        session_destroy();
        $this->redirectHome();
    
    
    }
    public function signIn() {

        if($this->isAuth()){
            $this->redirectHome();
            die();
        }
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Verifico campos obligatorios
        if (empty($email) || empty($password)) {
            $this->view->showLoginForm("Faltan datos obligatorios");
            die();
        }

        // Obtengo el usuario
        $user = $this->userModel->getByEmail($email);
        
        // Si el usuario NO existe le informo que el mail es incorrecto
        if(!$user){
            $this->view->showLoginForm("Usuario incorrecto");
            die();
        }
        // Si la contraseña es correcta
        if (password_verify($password, $user->password)) {
            
            // armo la sesion del usuario
            $_SESSION['ID_USER'] = $user->id;
            $_SESSION['EMAIL_USER'] = $user->email;

            $this->redirectHome();            
        } else {
            $this->view->showLoginForm("Contraseña incorrecta");
        }

    }

}
<?php

include_once 'app/views/auth.view.php';
include_once 'app/models/user.model.php';
include_once 'app/controllers/menu.controller.php';

class AuthController {
    
    private $view;
    private $userModel;

    function __construct() {
        $this->view = new AuthView();
        $this->userModel = new UserModel();
        $this->menuView = new MenuView();
    }

    function showLogin($err = null){
        $menuController = new MenuController();
        $this->menuView->showHeader();
        $menuController->showNavBar();
        $this->showLoginForm($err);
        $this->menuView->showFooter();
    }

    function showSignup(){
        $this->authController->showLoginForm();
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
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
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

    public function logIn() {
        // Compruebo que no este logeado
        if($this->isAuth()){
            $this->redirectHome();
            die();
        }

        // Seteo datos
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Verifico campos obligatorios
        if (empty($email) || empty($password)) {
            $this->showLogin("Debe ingresar un email y contraseña");
            die();
        }

        // Obtengo el usuario
        $user = $this->userModel->getByEmail($email);
        
        // Si el usuario no existe le informo que el mail es incorrecto
        if(!$user){
            $this->showLogin("No se encontró un usuario correspondiente a este email");
            die();
        }

        // Si la contraseña es correcta
        if (password_verify($password, $user->password)) {
            // armo la sesion del usuario
            $_SESSION['ID_USER'] = $user->id;
            $_SESSION['EMAIL_USER'] = $user->email;

            $this->redirectHome();            
        } else {
            $this->showLogin("Contraseña incorrecta");
        }
    }

}
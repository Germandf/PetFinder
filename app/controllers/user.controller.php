<?php

include_once 'app/models/user.model.php';
include_once 'app/views/user.view.php';
include_once 'app/helpers/auth.helper.php';

class UserController {
    private $model;
    private $view;
    private $authHelper;

    function __construct() {
        $this->model = new UserModel();
        $this->view = new UserView();
        $this->authHelper = new AuthHelper();
    }

    function showLogin($err = null) {
        if($this->authHelper->isAuth()){
            $this->redirectHome();
            die();
        }
        $this->view->showLoginForm($err);
    }

    function showSignUp($err = null) {
        if($this->authHelper->isAuth()){
            $this->redirectHome();
            die();
        }
        $this->view->showSignUpForm($err);
    }

    function redirectHome(){
        header("Location: " . BASE_URL);
    }

    public function logOut(){
        session_start();
        session_destroy();
        $this->redirectHome();
    }

    public function logIn() {
        // Compruebo que no este logeado
        if($this->authHelper->isAuth()){
            $this->redirectHome();
            die();
        }
        // Seteo datos
        $email = $_POST['email'];
        $password = $_POST['password'];
        // Verifico campos obligatorios
        if (empty($email) || empty($password)) {
            $this->view->showLoginForm("Debe ingresar un email y contraseña");
            die();
        }
        // Obtengo el usuario
        $user = $this->model->getByEmail($email);
        // Si el usuario no existe le informo que el mail es incorrecto
        if(!$user){
            $this->view->showLoginForm("No se encontró un usuario correspondiente a este email");
            die();
        }
        // Si la contraseña es correcta
        if (password_verify($password, $user->password)) {
            // armo la sesion del usuario
            $this->loginUserByEmail($email);
        } else {
            $this->view->showLoginForm("Contraseña incorrecta");
        }
    }
    
    // Logea al usuario, inicia la sesion
    function loginUserByEmail($email){
        $user = $this->model->getByEmail($email);
        if($user){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['ID_USER'] = $user->id;
            $_SESSION['NAME_USER'] = $user->name;
            $_SESSION['EMAIL_USER'] = $user->email;
            $_SESSION['PERMISSION_USER'] = $user->permission_id;
            $this->redirectHome();            
        }
    }

    // Agrega un usuario
    function addUser(){
        if($this->authHelper->isAuth()){
            $this->redirectHome();
            die();
        }
        // Seteo datos
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordRepeat = $_POST['passwordrepeat'];
        // Si hay algun error, hace un die
        $this->validateAddUserForm($email, $password, $passwordRepeat, $name, $surname);
         
        $hashedPassword = password_hash($password , PASSWORD_DEFAULT);

        if($this->model->add($email, $hashedPassword, $name, $surname)){
            $this->loginUserByEmail($email);
        }
        else{
            $this->view->showSignupForm('Ocurrió un error en el servidor, intente nuevamente más tarde');
        }
    }

    // Valida que todos los datos del registro sean correctos
    function validateAddUserForm($email, $password, $passwordRepeat, $name, $surname){
        // Valido los datos
        if (empty($email) || empty($password) || empty($name) || empty($surname) || empty($passwordRepeat)) {
            $this->view->showSignupForm('Debe completar todos los campos.');
            die();
        }
        // Si las contraseñas no son iguales
        if($password != $passwordRepeat){
            $this->view->showSignupForm('Las contraseñas deben ser iguales');
            die();
        }
        // Si el mail es incorrecto
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->view->showSignupForm('Email incorrecto');
            die();
        }
        // Si ya existe un usuario registrado con ese mail
        if($this->userExistsByEmail($email)){
            $this->view->showSignupForm('Ya hay un usuario registrado con ese Email.');
            die();
        }  
    }

    // Chequea si ya existe un usuario con ese mail
    function userExistsByEmail($email){
        // Obtengo el usuario
        $user = $this->model->getByEmail($email);
        // Si el usuario no existe devuelvo false
        if(!$user){
            return false;
        }
        // Si existe devuelvo true
        return true;
    }
}

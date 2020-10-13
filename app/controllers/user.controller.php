<?php

include_once 'app/models/user.model.php';
include_once 'app/controllers/auth.controller.php';

class UserController {
    private $authController;
    private $menuController;
    private $userModel;

    function __construct(){
        $this->authController = new AuthController();
        $this->menuController = new MenuController();
        $this->userModel  = new UserModel();
    }

    // Chequea si ya existe un usuario con ese mail
    function userExistsByEmail($email){
        // Obtengo el usuario
        $user = $this->userModel->getByEmail($email);
        // Si el usuario no existe devuelvo false
        if(!$user){
            return false;
        }
        // Si existe devuelvo true
        return true;
    }

    // Valida que todos los datos del registro sean correctos
    function validateAddUserForm($email, $password, $passwordRepeat, $name, $surname){
        // Valido los datos
        if (empty($email) || empty($password) || empty($name) || empty($surname) || empty($passwordRepeat)) {
            $this->menuController->showSignup('Debe completar todos los campos.');
            die();
        }
        // Si las contraseñas no son iguales
        if($password != $passwordRepeat){
            $this->menuController->showSignup('Las contraseñas deben ser iguales');
            die();
        }
        // Si el mail es incorrecto
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->menuController->showSignup('Email incorrecto');
            die();
        }
        // Si ya existe un usuario registrado con ese mail
        if($this->userExistsByEmail($email)){
            $this->menuController->showSignup('Ya hay un usuario registrado con ese Email.');
            die();
        }  
    }

    // Agrega un usuario
    function AddUser(){
        if($this->authController->isAuth()){
            $this->authController->redirectHome();
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

        if($this->userModel->add($email, $hashedPassword, $name, $surname)){
            $this->authController->loginUserByEmail($email);
        }
        else{
            $this->menuController->showSignup('Ocurrió un error en el servidor, intente nuevamente más tarde');
        }
    }
}

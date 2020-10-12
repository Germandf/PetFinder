<?php

include_once 'app/models/user.model.php';
include_once 'app/controllers/auth.controller.php';

class UserController {
    private $authController;
    private $userModel;

    function __construct(){
        $this->authController = new AuthController();
        $this->userModel  = new UserModel();
    }
    function userExistsByEmail($email){
        // Obtengo el usuario
        $user = $this->userModel->getByEmail($email);
        
        // Si el usuario no existe devuelvo false
        if(!$user){
            return false;
        }

        return true; //Si existe devuelvo true
    }

    function validateAddUserForm($email, $password, $passwordRepeat, $name, $surname){
        //Valido los datos
        if (empty($email) || empty($password) 
         || empty($name)  || empty($surname) || empty($passwordRepeat)) {
            $this->authController->showSignup('Debe completar todos los campos.');
            die();
        }

        if($password != $passwordRepeat){
            $this->authController->showSignup('Las contraseñas deben ser iguales');
            die();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {//Valido el mail
            $this->authController->showSignup('Email incorrecto');
            die();
        }

        if($this->userExistsByEmail($email)){
            $this->authController->showSignup('Ya hay un usuario registrado con ese Email.');
            die();
        }  
    }
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
        
        $this->validateAddUserForm($email, $password, $passwordRepeat, $name, $surname);
        

        if($this->userModel->add($email, $password, $name, $surname)){
            $this->authController->loginUserByEmail($email);
        };
    }

}

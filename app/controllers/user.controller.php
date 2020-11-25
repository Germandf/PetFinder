<?php

include_once 'app/models/user.model.php';
include_once 'app/models/pet.model.php';
include_once 'app/views/user.view.php';
include_once 'app/views/menu.view.php';
include_once 'app/helpers/auth.helper.php';

class UserController {
    private $model;
    private $view;
    private $authHelper;
    private $menuView;

    function __construct() {
        $this->model = new UserModel();
        $this->petModel = new PetModel();
        $this->view = new UserView();
        $this->authHelper = new AuthHelper();
        $this->menuView = new MenuView();
    }

    // Muestra formulario de inicio de sesion
    function showLogin($err = null) {
        if($this->authHelper->isAuth()){
            $this->redirectHome();
            die();
        }
        $this->view->showLoginForm($err);
    }

    // Muestra formulario de registro
    function showSignUp($err = null) {
        if($this->authHelper->isAuth()){
            $this->redirectHome();
            die();
        }
        $this->view->showSignUpForm($err);
    }

    // Deslogea al usuario
    public function logOut(){
        session_start();
        session_destroy();
        $this->redirectHome();
    }

    // Logea al usuario
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
    
    // Una vez logeado, armo la sesion del usuario
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
        // Valido los datos
        $this->validateAddUserForm($email, $password, $passwordRepeat, $name, $surname);
        // Hasheo la password
        $hashedPassword = password_hash($password , PASSWORD_DEFAULT);
        // Si no devuelve error, logea automaticamente
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
        $user = $this->model->getByEmail($email);
        if(!$user){
            return false;
        }
        return true;
    }
    
    // Muestra la tabla usuarios
    function showAll(){
        if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
            $users = $this->model->getAll();
            $this->view->showAll($users);
        }else{
            $this->menuView->showError("Acceso denegado");
        }
    }

    // Cambia los privilegios de un usuario
    function updateUserPermissions($userId, $userPermission){
        if($this->authHelper->isAdmin()){
            if($this->model->getById($userId)){ //Si existe el usuario
                if($this->model->setUserPermission($userId, $userPermission)){
                    header("Location: " . BASE_URL. 'usuarios');
                }else{
                    $this->menuView->showError("Ocurrió un error al cambiar el permiso. Por favor comuniquese con un administrador.");
                }
            }else{
                $this->menuView->showError("No se encontró el usuario");
            }
        }else{
            $this->menuView->showError("Acceso denegado");
        }
    }

    // Borra un usuario de la base de datos
    function deleteUser($userId){
        if($this->authHelper->isAdmin()){
            if($this->model->getById($userId)){ //Si existe el usuario
                //Checkeo que el usuario no tenga ninguna mascota asociada antes de eliminar
                if(!($this->petModel->getAllByUser($userId))){
                    $this->model->delete($userId);
                    header("Location: " . BASE_URL. 'usuarios');
                }else{
                    $this->menuView->showError("El usuario que intenta eliminar tiene mascotas perdidas asociadas, elimine éstas primero e intente nuevamente");
                }
            }else{
                $this->menuView->showError("No se encontró el usuario");
            }
        }else{
            $this->menuView->showError("Acceso denegado");
        }
    }

    function redirectHome(){
        header("Location: " . BASE_URL);
    }
}

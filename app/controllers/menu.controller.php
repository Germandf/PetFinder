<?php

include_once 'app/views/menu.view.php';
include_once 'app/controllers/pet.controller.php';
include_once 'app/controllers/user.controller.php';

class MenuController{

    private $view;
    private $petController;
    private $userController;

    function __construct() {
        $this->view = new MenuView();
        $this->petController = new PetController();
        $this->userController = new UserController();
    }

    // Cargo la pagina about
    function showAbout(){
        $this->view->showAbout();
    }
    
    // Cargo la pagina admin
    function showAdmin(){
        $this->view->showHeader();
        $this->view->showNavBar();
        if($this->userController->isAuth() && $this->userController->isAdmin()){
            $this->view->showAdminMenu();
            $this->petController->showAdminTables();
            $this->petController->showAllNotFound();
        }else{
            $this->view->showError("Acceso denegado");
        }
        $this->view->showFooter();
    }
}
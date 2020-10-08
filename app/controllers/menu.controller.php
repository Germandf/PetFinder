<?php

include_once 'app/views/menu.view.php';
include_once 'app/controllers/pet.controller.php';
include_once 'app/controllers/auth.controller.php';

class MenuController{

    private $view;
    private $petController;
    private $AuthController;


    function __construct() {
        $this->view = new MenuView();
        $this->petController = new PetController();
        $this->authController = new AuthController();
    }

    function showHome(){
        $this->view->showHeader();
        $this->view->showNavbar();
        $this->view->showPetFilter();
        $this->petController->showAllNotFound();
        $this->view->showFooter();
    }

    function showAdmin(){
        $this->view->showHeader();
        $this->view->showNavbar();
        
        $this->view->showFooter();
    }

    function showCategories(){
        $this->view->showCategories();
    }

    function showAbout(){
        $this->view->showAbout();
    }

    function showLogin(){
        $this->view->showLogin();
    }

    function showSignup(){
        $this->view->showSignup();
    }
}
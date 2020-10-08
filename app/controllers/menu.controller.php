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
        $this->showNavBar();
        $this->view->showPetFilter();
        $this->petController->showAllNotFound();
        $this->view->showFooter();
    }

    function showNavBar(){
        if( $this->authController->isAuth()){
            $this->view->showNavbar(true);
        }else{
            $this->view->showNavbar();

        }
    }
    function showAdmin(){
       
        $this->showNavBar();
        
        $this->view->showFooter();
    }

    function showCategories(){
        $this->view->showCategories();
    }

    function showAbout(){
        $this->view->showAbout();
    }

    function showLogin(){
        $this->authController->showLoginForm();
    }

    function showSignup(){
        $this->authController->showLoginForm();
    }
}
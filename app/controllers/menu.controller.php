<?php

include_once 'app/views/menu.view.php';
include_once 'app/controllers/pet.controller.php';
include_once 'app/controllers/auth.controller.php';

class MenuController{

    private $view;
    private $petController;
    private $authController;

    function __construct() {
        $this->view = new MenuView();
        $this->petController = new PetController();
        $this->authController = new AuthController();
    }

    function showHome(){
        $this->view->showHeader();
        $this->showNavBar();
        $this->petController->showPetFilter();
        $this->petController->showAllNotFound();
        $this->view->showFooter();
    }
    
    function showAdmin(){
        $this->view->showHeader();
        $this->showNavBar();
        $this->view->showAdminMenu();
        $this->petController->showAdminTables();
        $this->petController->showAllNotFound();
        $this->view->showFooter();
    }

    function showCategories(){
        $this->view->showHeader();
        $this->showNavBar();
        $this->petController->showCategoriesTables();
        $this->view->showFooter();
    }

    function showAbout(){
        $this->view->showAbout();
    }

    function showPet($id){
        $this->view->showHeader();
        $this->showNavBar();
        $this->petController->show($id);
        $this->view->showFooter();
    }

    function filterPets(){
        $this->view->showHeader();
        $this->showNavBar();
        $this->petController->filter();
        $this->view->showFooter();
    }

    function showNavBar(){
        if( $this->authController->isAuth()){
            $this->view->showNavbar(true);
        }else{
            $this->view->showNavbar();
        }
    }
}
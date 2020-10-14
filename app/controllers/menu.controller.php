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

    // Cargo la pagina home
    function showHome(){
        $this->view->showHeader();
        $this->showNavBar();
        $this->petController->showPetFilter();
        $this->petController->showAllNotFound();
        $this->view->showFooter();
    }
    
    // Cargo la pagina admin
    function showAdmin(){
        $this->view->showHeader();
        $this->showNavBar();
        if($this->authController->isAuth() && $this->authController->isAdmin()){
            $this->view->showAdminMenu();
            $this->petController->showAdminTables();
            $this->petController->showAllNotFound();
        }else{
            $this->view->showError("Acceso denegado");
        }
        $this->view->showFooter();
    }

    // Cargo la pagina mypets
    function showMyPets(){
        if($this->authController->isAuth()){
            $this->view->showHeader();
            $this->showNavBar();
            $this->view->showMisMascotas();
            $userId = $this->authController->getUserId();
            $this->petController->showAllMyPets($userId);
            $this->view->showFooter();
        }else{
            $this->authController->redirectLogin();
        }
    }

    // Cargo la pagina categories
    function showCategories(){
        $this->view->showHeader();
        $this->showNavBar();
        $this->petController->showCategoriesTables();
        $this->view->showFooter();
    }

    // Cargo la pagina about
    function showAbout(){
        $this->view->showHeader();
        $this->showNavBar();
        $this->view->showAbout();
        $this->view->showFooter();
    }

    // Muestro mas detalles de una mascota
    function showPet($id){
        $this->view->showHeader();
        $this->showNavBar();
        $this->petController->show($id);
        $this->view->showFooter();
    }

    // Muestro todas las mascotas que correspondan con el filtro
    function showFilterPets(){
        $this->view->showHeader();
        $this->showNavBar();
        $this->petController->showPetFilter();
        $this->petController->filter();
        $this->view->showFooter();
    }

    // Cargo la pagina login
    function showLogin($err = null){
        $this->view->showHeader();
        $this->showNavBar();
        $this->authController->showLoginForm($err);
        $this->view->showFooter();
    }

    // Cargo la pagina signup
    function showSignup($err = null){
        $this->view->showHeader();
        $this->showNavBar();
        $this->authController->showSignUpForm($err);
    }

    function showAccessDenied(){
        $this->view->showHeader();
        $this->view->showNavBar(true);
        $this->view->showError('Acceso denegado');
        $this->view->showFooter();
    }

    // Cargo el navbar dependiendo si esta logeado o no
    function showNavBar(){
        if( $this->authController->isAuth()){
            $this->view->showNavbar(true);
        }else{
            $this->view->showNavbar();
        }
    }
}
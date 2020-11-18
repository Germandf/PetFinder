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

    // Cargo la pagina home
    function showHome(){
        $this->view->showHeader();
        $this->view->showNavBar();
        $this->petController->showPetFilter();
        $this->petController->showAllNotFound();
        $this->view->showFooter();
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

    // Cargo la pagina mypets
    function showMyPets(){
        if($this->userController->isAuth()){
            $this->view->showHeader();
            $this->view->showNavBar();
            $this->view->showMisMascotas();
            $userId = $this->userController->getUserId();
            $this->petController->showAllMyPets($userId);
            $this->view->showFooter();
        }else{
            $this->userController->redirectLogin();
        }
    }

    // Cargo la pagina categories
    function showCategories(){
        $this->view->showHeader();
        $this->view->showNavBar();
        $this->petController->showCategoriesTables();
        $this->view->showFooter();
    }

    // Cargo la pagina about
    function showAbout(){
        $this->view->showHeader();
        $this->view->showNavBar();
        $this->view->showAbout();
        $this->view->showFooter();
    }

    // Muestro mas detalles de una mascota
    function showPet($id){
        $this->view->showHeader();
        $this->view->showNavBar();
        $this->petController->show($id);
        $this->view->showFooter();
    }

    // Muestro todas las mascotas que correspondan con el filtro
    function showFilterPets(){
        $this->view->showHeader();
        $this->view->showNavBar();
        $this->petController->showPetFilter();
        $this->petController->filter();
        $this->view->showFooter();
    }

    function showAccessDenied(){
        $this->view->showHeader();
        $this->view->showNavBar();
        $this->view->showError('Acceso denegado');
        $this->view->showFooter();
    }
}
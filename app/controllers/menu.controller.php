<?php

include_once 'app/models/pet.model.php';
include_once 'app/views/menu.view.php';

class MenuController{

    private $model;
    private $view;

    function __construct() {
        $this->model = new PetModel();
        $this->view = new MenuView();
    }

    function showHome(){
        $this->view->showHome();
    }

    function showAdmin(){
        $this->view->showAdmin();
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
<?php
    include_once 'app/models/pet.model.php';
    include_once 'app/views/pet.view.php';

    class PetController{

        private $model;
        private $view;

        function __construct() {
            $this->model = new PetModel();
            $this->view = new PetView();
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
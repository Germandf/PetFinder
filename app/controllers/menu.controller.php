<?php

include_once 'app/views/menu.view.php';

class MenuController{

    private $view;

    function __construct() {
        $this->view = new MenuView();
    }

    // Cargo la pagina about
    function showAbout(){
        $this->view->showAbout();
    }
}
<?php

require_once('libs/smarty/libs/Smarty.class.php');

class MenuView{

    private $smarty;

    function __construct(){
        $this->smarty =  new Smarty();
    }

    function showHome(){
        $this->smarty->display('templates/home.tpl');  
    }

    function showAdmin(){
        $this->smarty->display('templates/admin.tpl');  
    }

    function showCategories(){
        $this->smarty->display('templates/categories.tpl');
    }

    function showAbout(){
        $this->smarty->display('templates/about.tpl');
    }

    function showLogin(){
        $this->smarty->display('templates/login.tpl');
    }

    function showSignup(){
        $this->smarty->display('templates/signup.tpl');
    }
}
<?php

require_once('libs/smarty/libs/Smarty.class.php');

class MenuView{

    private $smarty;

    function __construct(){
        $this->smarty =  new Smarty();
    }

    function showHeader(){
        $this->smarty->display('templates/header.tpl');  
    }

    function showNavbar(){
        $this->smarty->display('templates/navbar.tpl');  
    }

    function showFooter(){
        $this->smarty->display('templates/footer.tpl');  
    }

    function showPetFilter(){
        $this->smarty->display('templates/petfilter.tpl');  
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

    function showError($msg){
        $this->smarty->assign('msg', $msg);
        $this->smarty->display('templates/error.tpl');
    }
}
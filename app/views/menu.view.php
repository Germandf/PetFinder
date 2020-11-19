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
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->smarty->display('templates/navbar.tpl');  
    }

    function showFooter(){
        $this->smarty->display('templates/footer.tpl');  
    }

    function showAdminMenu(){
        $this->smarty->display('templates/adminmenu.tpl');  
    }

    function showAbout(){
        $this->showHeader();
        $this->showNavbar();
        $this->smarty->display('templates/about.tpl');
        $this->showFooter();
    }

    function showError($msg){
        $this->showHeader();
        $this->showNavbar();
        $this->smarty->assign('msg', $msg);
        $this->smarty->display('templates/error.tpl');
        $this->showFooter();
    }
}
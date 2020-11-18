<?php

require_once('libs/smarty/libs/Smarty.class.php');
require_once('app/views/menu.view.php');

class UserView{

    private $smarty;
    private $menuView;

    function __construct(){
        $this->smarty = new Smarty();
        $this->menuView = new MenuView();
    }

    function showLoginForm($err = null){
        $this->menuView->showHeader();
        $this->menuView->showNavbar();
        $this->smarty->assign('error', $err);
        $this->smarty->display('templates/login.tpl');
        $this->menuView->showFooter();
    }

    function showSignUpForm($err = null){
        $this->menuView->showHeader();
        $this->menuView->showNavbar();
        $this->smarty->assign('error', $err);
        $this->smarty->display('templates/signup.tpl');
        $this->menuView->showFooter();
    }

}
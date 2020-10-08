<?php

require_once('libs/smarty/libs/Smarty.class.php');

class AuthView{

    private $smarty;

    function __construct(){
        $this->smarty = new Smarty();
    }

    function showLoginForm(){
        $this->smarty->assign('pets', $pets);
        $this->smarty->display('templates/login.tpl');
    }

   
}
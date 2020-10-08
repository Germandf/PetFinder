<?php

require_once('libs/smarty/libs/Smarty.class.php');

class AuthView{

    private $smarty;

    function __construct(){
        $this->smarty = new Smarty();
    }

    function showLoginForm($err = null){
        $this->smarty->assign('error', $err);
        $this->smarty->display('templates/login.tpl');
    }

}
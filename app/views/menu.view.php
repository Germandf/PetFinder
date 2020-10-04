<?php
    require_once('libs/smarty/libs/Smarty.class.php');

    class MenuView{
        var $templateEngine;
        function __construct(){
            $this->templateEngine =  new Smarty();
        }
        function show(){
            $this->templateEngine->display('templates/header.tpl');  
            $this->templateEngine->display('templates/navbar.tpl');  
        }
    }
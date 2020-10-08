<?php

require_once('libs/smarty/libs/Smarty.class.php');

class PetView{

    private $smarty;

    function __construct(){
        $this->smarty = new Smarty();
    }

    function showAllNotFound($pets){
        $this->smarty->assign('pets', $pets);
        $this->smarty->display('templates/allpetsnotfound.tpl');
    }

    function show($pet){

    }
}
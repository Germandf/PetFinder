<?php

require_once('libs/smarty/libs/Smarty.class.php');

class CityView{

    private $smarty;

    function __construct(){
        $this->smarty = new Smarty();
    }

    function showAddNewCity($err = null, $city = null){
        $this->smarty->assign('error', $err);
        $this->smarty->assign('city', $city);
        $this->smarty->display('templates/addcityform.tpl');
    }
}
<?php

require_once('libs/smarty/libs/Smarty.class.php');

class AnimalTypeView{

    private $smarty;

    function __construct(){
        $this->smarty = new Smarty();
    }

    function showAddNewAnimalType($err = null, $animalType = null){
        $this->smarty->assign('error', $err);
        $this->smarty->assign('animalType', $animalType);
        $this->smarty->display('templates/addanimaltypeform.tpl');
    }
}
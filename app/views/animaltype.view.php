<?php

require_once('libs/smarty/libs/Smarty.class.php');
require_once('app/views/menu.view.php');

class AnimalTypeView{

    private $smarty;
    private $menuView;

    function __construct(){
        $this->smarty = new Smarty();
        $this->menuView = new MenuView();
    }

    function showAddNewAnimalType($err = null, $animalType = null){
        $this->menuView->showHeader();
        $this->menuView->showNavBar();
        $this->smarty->assign('error', $err);
        $this->smarty->assign('animalType', $animalType);
        $this->smarty->display('templates/addanimaltypeform.tpl');
        $this->menuView->showFooter();
    }
}
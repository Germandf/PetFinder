<?php

require_once('libs/smarty/libs/Smarty.class.php');
require_once('app/views/menu.view.php');

class CityView{

    private $smarty;
    private $menuView;

    function __construct(){
        $this->smarty = new Smarty();
        $this->menuView = new MenuView();
    }

    function showAddNewCity($err = null, $city = null){
        $this->menuView->showHeader();
        $this->menuView->showNavBar();
        $this->smarty->assign('error', $err);
        $this->smarty->assign('city', $city);
        $this->smarty->display('templates/addcityform.tpl');
        $this->menuView->showFooter();
    }
}
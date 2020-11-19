<?php

require_once('libs/smarty/libs/Smarty.class.php');
require_once('app/views/menu.view.php');

class PetView{

    private $smarty;
    private $menuView;

    function __construct(){
        $this->smarty = new Smarty();
        $this->menuView = new MenuView();
    }

    function showHome($petCategories, $pets){
        $this->menuView->showHeader();
        $this->menuView->showNavBar();
        $this->showPetFilter($petCategories);
        $this->showAllNotFound($pets);
        $this->menuView->showFooter();
    }

    function showAllMyPets($pets){
        $this->menuView->showHeader();
        $this->menuView->showNavBar();
        $this->smarty->display('templates/mypetsmenu.tpl');
        $this->smarty->assign('pets', $pets);
        $this->smarty->display('templates/mypets.tpl');
        $this->menuView->showFooter();
    }

    function showCategories($petCategories){
        $this->menuView->showHeader();
        $this->menuView->showNavBar();
        $this->smarty->assign('animaltypes', $petCategories[0]);
        $this->smarty->assign('cities', $petCategories[1]);
        $this->smarty->assign('genders', $petCategories[2]);
        $this->smarty->display('templates/categories.tpl');
        $this->menuView->showFooter();
    }
    
    function showByFilter($petCategories, $pets){
        $this->menuView->showHeader();
        $this->menuView->showNavBar();
        $this->showPetFilter($petCategories);
        $this->smarty->assign('pets', $pets);
        $this->smarty->display('templates/filteredpets.tpl');
        $this->menuView->showFooter();
    }

    function show($pet){
        $this->menuView->showHeader();
        $this->menuView->showNavBar();
        $this->smarty->assign('pet', $pet);
        $this->smarty->display('templates/pet.tpl');
        $this->menuView->showFooter();
    }

    function showAddPetForm($err = null, $petCategories, $pet = null){
        $this->menuView->showHeader();
        $this->menuView->showNavBar();
        $this->smarty->assign('animaltypes', $petCategories[0]);
        $this->smarty->assign('cities', $petCategories[1]);
        $this->smarty->assign('genders', $petCategories[2]);
        $this->smarty->assign('error', $err);
        $this->smarty->assign('pet', $pet);
        $this->smarty->display('templates/addpetform.tpl');
        $this->menuView->showFooter();
    }

    function showPetFilter($petCategories){
        $this->smarty->assign('animaltypes', $petCategories[0]);
        $this->smarty->assign('cities', $petCategories[1]);
        $this->smarty->assign('genders', $petCategories[2]);
        $this->smarty->display('templates/petfilter.tpl');
    }

    function showAllNotFound($pets){
        $this->smarty->assign('pets', $pets);
        $this->smarty->display('templates/allpetsnotfound.tpl');
    }

    function showAdminTables($animaltypes, $cities){
        $this->smarty->assign('animaltypes', $animaltypes);
        $this->smarty->assign('cities', $cities);
        $this->smarty->display('templates/admintables.tpl');
    }
}
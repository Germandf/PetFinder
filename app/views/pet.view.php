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

    function showPetFilter($animaltypes, $cities, $genders){
        $this->smarty->assign('animaltypes', $animaltypes);
        $this->smarty->assign('cities', $cities);
        $this->smarty->assign('genders', $genders);
        $this->smarty->display('templates/petfilter.tpl');
    }

    function showAdminTables($animaltypes, $cities){
        $this->smarty->assign('animaltypes', $animaltypes);
        $this->smarty->assign('cities', $cities);
        $this->smarty->display('templates/admintables.tpl');
    }

    function showCategoriesTables($animaltypes, $cities, $genders){
        $this->smarty->assign('animaltypes', $animaltypes);
        $this->smarty->assign('cities', $cities);
        $this->smarty->assign('genders', $genders);
        $this->smarty->display('templates/categories.tpl');
    }

    function show($pet){
        $this->smarty->assign('pet', $pet);
        $this->smarty->display('templates/pet.tpl');
    }
}
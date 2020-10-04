<?php
    require_once('app/views/menu.view.php');

    class MenuController{
        function showNavBar(){
            $menuView = new MenuView();
            $menuView->show();

        }
    }
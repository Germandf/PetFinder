<?php

include_once 'app/controllers/auth.controller.php';
include_once 'app/models/city.model.php';
include_once 'app/views/city.view.php';
include_once 'app/views/menu.view.php';

class CityController {
    private $authController;
    private $model;
    private $view;
    private $menuView;

    function __construct(){
        $this->authController = new AuthController();
        $this->model = new CityModel();
        $this->view = new CityView();
        $this->menuView = new MenuView();
    }

    function showAddNewCity($err = null, $city = null){
        if($this->authController->isAuth() && $this->authController->isAdmin()){
            $this->menuView->showHeader();
            $this->menuView->showNavBar();
            $this->view->showAddNewCity($err, $city);
            $this->menuView->showFooter();
        } else{
            $menuController = new MenuController();
            $menuController->showAccessDenied();
        }
    }

    function add($city = null){
        $name = $_POST['name'];
        // Verifico campos obligatorios
        if (empty($name)) {
            $this->showAddNewCity('Faltan datos obligatorios');
            die();
        }
        // Si estamos editando, redirige a editar con los datos actualizados
        if($city != null){
            $this->model->update($name, $city->id);
            header("Location: " . BASE_URL . "admin");
        }
        // Si no estamos editando, lo inserta y volvemos a admin
        else{
            $this->model->add($name);
            header("Location: " . BASE_URL . "admin");
        }
    }

    function edit($id){
        $city = $this->model->get($id);
        if($this->authController->isAdmin()){
            $this->showAddNewCity(null, $city);
        }else{
            $menuController = new MenuController();
            $menuController->showAccessDenied();
        }
    }

    function update($id){
        // Primero obtengo la ciudad a partir del ID
        $city = $this->model->get($id);
        // Miro si el usuario tiene permisos
        if($this->authController->isAdmin()){
            $this->add($city);
        } else{
            $menuController = new MenuController();
            $menuController->showAccessDenied();
        }
    }

    // Elimino la ciudad del sistema
    function delete($id) {
        // Miro si el usuario tiene permisos
        if($this->authController->isAdmin()){
            $this->model->remove($id);
            header("Location: " . BASE_URL . "admin");
        } else{
            $menuController = new MenuController();
            $menuController->showAccessDenied();
        }
    }
}
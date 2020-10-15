<?php

include_once 'app/controllers/auth.controller.php';
include_once 'app/models/animaltype.model.php';
include_once 'app/views/animaltype.view.php';
include_once 'app/views/menu.view.php';

class AnimalTypeController {
    private $authController;
    private $model;
    private $view;
    private $menuView;

    function __construct(){
        $this->authController = new AuthController();
        $this->model = new AnimalTypeModel();
        $this->view = new AnimalTypeView();
        $this->menuView = new MenuView();
    }

    function showAddNewAnimalType($err = null, $animalType = null){
        if($this->authController->isAuth() && $this->authController->isAdmin()){
            $this->menuView->showHeader();
            $this->menuView->showNavBar();
            $this->view->showAddNewAnimalType($err, $animalType);
            $this->menuView->showFooter();
        } else{
            $menuController = new MenuController();
            $menuController->showAccessDenied();
        }
    }

    function add($animalType = null){
        $name = $_POST['name'];
        // Verifico campos obligatorios
        if (empty($name)) {
            $this->showAddNewAnimalType('Faltan datos obligatorios');
            die();
        }
        // Si estamos editando, redirige a editar con los datos actualizados
        if($animalType != null){
            $this->model->update($name, $animalType->id);
            header("Location: " . BASE_URL . "admin");
        }
        // Si no estamos editando, lo inserta y volvemos a admin
        else{
            $this->model->add($name);
            header("Location: " . BASE_URL . "admin");
        }
    }

    function edit($id){
        $animalType = $this->model->get($id);
        if($this->authController->isAdmin()){
            $this->showAddNewAnimalType(null, $animalType);
        }else{
            $menuController = new MenuController();
            $menuController->showAccessDenied();
        }
    }

    function update($id){
        // Primero obtengo la ciudad a partir del ID
        $animalType = $this->model->get($id);
        // Miro si el usuario tiene permisos
        if($this->authController->isAdmin()){
            $this->add($animalType);
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
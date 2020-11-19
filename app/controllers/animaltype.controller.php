<?php

include_once 'app/controllers/user.controller.php';
include_once 'app/models/animaltype.model.php';
include_once 'app/views/animaltype.view.php';
include_once 'app/views/menu.view.php';

class AnimalTypeController {
    private $userController;
    private $model;
    private $view;
    private $menuView;

    function __construct(){
        $this->userController = new UserController();
        $this->model = new AnimalTypeModel();
        $this->view = new AnimalTypeView();
        $this->menuView = new MenuView();
    }

    // Muestra el formulario para agregar o editar un tipo de animal
    function showAddNewAnimalType($err = null, $animalType = null){
        if($this->userController->isAuth() && $this->userController->isAdmin()){
            $this->view->showAddNewAnimalType($err, $animalType);
        } else{
            $this->menuView->showError("Acceso denegado");
        }
    }

    // Agrega o edita un tipo de animal
    function add($animalType = null){
        if($this->userController->isAuth() && $this->userController->isAdmin()){
            $name = isset($_POST['name']) ? $_POST['name'] : null;
            // Verifico campos obligatorios
            if (empty($name)) {
                $this->showAddNewAnimalType('Faltan datos obligatorios');
            } else {
                // Si estamos editando, redirige a editar con los datos actualizados
                if($animalType != null){
                    $this->model->update($name, $animalType->id);
                    header("Location: " . BASE_URL . "admin");
                } else{ // Si no estamos editando, lo inserta y volvemos a admin
                    $this->model->add($name);
                    header("Location: " . BASE_URL . "admin");
                }
            }
        } else{
            $this->menuView->showError("Acceso denegado");
        }
    }

    // Muestro formulario para actualizar tipo de animal
    function edit($id){
        $animalType = $this->model->get($id);
        if($animalType){
            if($this->userController->isAuth() && $this->userController->isAdmin()){
                $this->showAddNewAnimalType(null, $animalType);
            }else{
                $this->menuView->showError("Acceso denegado");
            }
        } else{
            $this->menuView->showError("No se encontró el tipo de animal");
        }
    }

    // Actualizo tipo de animal
    function update($id){
        $animalType = $this->model->get($id);
        if($animalType){
            if($this->userController->isAuth() && $this->userController->isAdmin()){
                $this->add($animalType);
            } else{
                $this->menuView->showError("Acceso denegado");
            }
        } else{
            $this->menuView->showError("No se encontró el tipo de animal");
        }
    }

    // Elimino el tipo de animal del sistema
    function delete($id) {
        $animalType = $this->model->get($id);
        if($animalType){
            if($this->userController->isAuth() && $this->userController->isAdmin()){
                $this->model->remove($id);
                header("Location: " . BASE_URL . "admin");
            } else{
                $this->menuView->showError("Acceso denegado");
            }
        } else{
            $this->menuView->showError("No se encontró el tipo de animal");
        }
    }
}
<?php

include_once 'app/models/animaltype.model.php';
include_once 'app/views/animaltype.view.php';
include_once 'app/views/menu.view.php';
include_once 'app/helpers/auth.helper.php';

class AnimalTypeController {

    private $model;
    private $view;
    private $menuView;
    private $authHelper;

    function __construct(){
        $this->model = new AnimalTypeModel();
        $this->view = new AnimalTypeView();
        $this->menuView = new MenuView();
        $this->authHelper = new AuthHelper();
    }

    // Muestra el formulario para agregar o editar un tipo de animal
    function showAddNewAnimalType($err = null, $animalType = null){
        if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
            $this->view->showAddNewAnimalType($err, $animalType);
        } else{
            $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
        }
    }

    // Agrega o edita un tipo de animal
    function add($animalType = null){
        if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
            $name = isset($_POST['name']) ? $_POST['name'] : null;
            // Verifico campos obligatorios
            if (empty($name)) {
                $this->showAddNewAnimalType(DATA_MISSING);
            } else {
                // Si estamos editando, redirige a editar con los datos actualizados
                if($animalType != null){
                    if($this->model->animalTypeExists($name)){
                        $this->menuView->showError(ANIMAL_TYPE_EXISTS, ANIMAL_TYPE_EXISTS_MSG);
                    }else{
                        $this->model->update($name, $animalType->id);
                        header("Location: " . BASE_URL . "admin");
                    }
                } else{ // Si no estamos editando, lo inserta y volvemos a admin
                    if($this->model->animalTypeExists($name)){
                        $this->menuView->showError(ANIMAL_TYPE_EXISTS, ANIMAL_TYPE_EXISTS_MSG);
                    }else{
                        $this->model->add($name);
                        header("Location: " . BASE_URL . "admin");
                    }
                }   
            }
        } else{
            $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
        }
    }

    // Muestro formulario para actualizar tipo de animal
    function edit($id){
        $animalType = $this->model->get($id);
        if($animalType){
            if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
                $this->showAddNewAnimalType(null, $animalType);
            }else{
                $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
            }
        } else{
            $this->menuView->showError(ANIMAL_TYPE_NOT_FOUND, ANIMAL_TYPE_NOT_FOUND_MSG);
        }
    }

    // Actualizo tipo de animal
    function update($id){
        $animalType = $this->model->get($id);
        if($animalType){
            if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
                $this->add($animalType);
            } else{
                $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
            }
        } else{
            $this->menuView->showError(ANIMAL_TYPE_NOT_FOUND, ANIMAL_TYPE_NOT_FOUND_MSG);
        }
    }

    // Elimino el tipo de animal del sistema
    function delete($id) {
        $animalType = $this->model->get($id);
        if($animalType){
            if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
                $this->model->remove($id);
                header("Location: " . BASE_URL . "admin");
            } else{
                $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
            }
        } else{
            $this->menuView->showError(ANIMAL_TYPE_NOT_FOUND, ANIMAL_TYPE_NOT_FOUND_MSG);
        }
    }
}
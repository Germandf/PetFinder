<?php

include_once 'app/controllers/user.controller.php';
include_once 'app/models/city.model.php';
include_once 'app/views/city.view.php';
include_once 'app/views/menu.view.php';

class CityController {
    private $userController;
    private $model;
    private $view;
    private $menuView;

    function __construct(){
        $this->userController = new UserController();
        $this->model = new CityModel();
        $this->view = new CityView();
        $this->menuView = new MenuView();
    }

    // Muestra el formulario para agregar o editar una ciudad
    function showAddNewCity($err = null, $city = null){
        if($this->userController->isAuth() && $this->userController->isAdmin()){
            $this->view->showAddNewCity($err, $city);
        } else{
            $this->menuView->showError("Acceso denegado");
        }
    }

    // Agrega o edita una ciudad
    function add($city = null){
        if($this->userController->isAuth() && $this->userController->isAdmin()){
            $name = isset($_POST['name']) ? $_POST['name'] : null;
            // Verifico campos obligatorios
            if (empty($name)) {
                $this->showAddNewCity('Faltan datos obligatorios');
            } else {
                // Si estamos editando, redirige a editar con los datos actualizados
                if($city != null){
                    $this->model->update($name, $city->id);
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

    // Muestro formulario para actualizar ciudad
    function edit($id){
        $city = $this->model->get($id);
        if($city){
            if($this->userController->isAuth() && $this->userController->isAdmin()){
                $this->showAddNewCity(null, $city);
            }else{
                $this->menuView->showError("Acceso denegado");
            }
        } else{
            $this->menuView->showError("No se encontró la ciudad");
        }
    }

    // Actualizo ciudad
    function update($id){
        $city = $this->model->get($id);
        if($city){
            if($this->userController->isAuth() && $this->userController->isAdmin()){
                $this->add($city);
            } else{
                $this->menuView->showError("Acceso denegado");
            }
        } else{
            $this->menuView->showError("No se encontró la ciudad");
        }
    }

    // Elimino la ciudad del sistema
    function delete($id) {
        $city = $this->model->get($id);
        if($city){
            if($this->userController->isAuth() && $this->userController->isAdmin()){
                $this->model->remove($id);
                header("Location: " . BASE_URL . "admin");
            } else{
                $this->menuView->showError("Acceso denegado");
            }
        } else{
            $this->menuView->showError("No se encontró la ciudad");
        }
    }
}
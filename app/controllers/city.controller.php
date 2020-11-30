<?php

include_once 'app/models/city.model.php';
include_once 'app/views/city.view.php';
include_once 'app/views/menu.view.php';
include_once 'app/helpers/auth.helper.php';

class CityController {
    
    private $model;
    private $view;
    private $menuView;
    private $authHelper;

    function __construct(){
        $this->model = new CityModel();
        $this->view = new CityView();
        $this->menuView = new MenuView();
        $this->authHelper = new AuthHelper();
    }

    // Muestra el formulario para agregar o editar una ciudad
    function showAddNewCity($err = null, $city = null){
        if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
            $this->view->showAddNewCity($err, $city);
        } else{
            $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
        }
    }

    // Agrega o edita una ciudad
    function add($city = null){
        if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
            $name = isset($_POST['name']) ? $_POST['name'] : null;
            // Verifico campos obligatorios
            if (empty($name)) {
                $this->showAddNewCity(DATA_MISSING);
            } else {
                // Si estamos editando, redirige a editar con los datos actualizados
                if($city != null){
                    if($this->model->cityExists($name)){
                        $this->menuView->showError(CITY_EXISTS, CITY_EXISTS_MSG);
                    }else{
                        $this->model->update($name, $city->id);
                        header("Location: " . BASE_URL . "admin");
                    }
                } else{ // Si no estamos editando, lo inserta y volvemos a admin
                    if($this->model->cityExists($name)){
                        $this->menuView->showError(CITY_EXISTS, CITY_EXISTS_MSG);
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

    // Muestro formulario para actualizar ciudad
    function edit($id){
        $city = $this->model->get($id);
        if($city){
            if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
                $this->showAddNewCity(null, $city);
            }else{
                $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
            }
        } else{
            $this->menuView->showError(CITY_NOT_FOUND, CITY_NOT_FOUND_MSG);
        }
    }

    // Actualizo ciudad
    function update($id){
        $city = $this->model->get($id);
        if($city){
            if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
                $this->add($city);
            } else{
                $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
            }
        } else{
            $this->menuView->showError(CITY_NOT_FOUND, CITY_NOT_FOUND_MSG);
        }
    }

    // Elimino la ciudad del sistema
    function delete($id) {
        $city = $this->model->get($id);
        if($city){
            if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
                $this->model->remove($id);
                header("Location: " . BASE_URL . "admin");
            } else{
                $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
            }
        } else{
            $this->menuView->showError(CITY_NOT_FOUND, CITY_NOT_FOUND_MSG);
        }
    }
}
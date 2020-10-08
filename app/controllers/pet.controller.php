<?php

include_once 'app/models/pet.model.php';
include_once 'app/views/pet.view.php';
include_once 'app/views/menu.view.php';

class PetController {

    private $model;
    private $view;
    private $menuView;

    function __construct() {
        $this->model = new PetModel();
        $this->view = new PetView();
        $this->menuView = new MenuView();
    }

    // Muestra las ultimas mascotas perdidas
    function showAllNotFound() {
        $pets = $this->model->getAllNotFound();
        $this->view->showAllNotFound($pets);
    }

    // Muestra las tablas en admin segun la informacion en la db
    function showAdminTables() {
        $animaltypes = $this->model->getAllAnimalTypes();
        $cities = $this->model->getAllCities();
        $this->view->showAdminTables($animaltypes, $cities);
    }

    // Muestra mas informacion de la mascota
    function show($id) {
        $pet = $this->model->get($id);
        if($pet) {
            $this->view->show($pet);
        }
        else {
            $this->menuView->showError('Mascota no encontrada');
        }
    }

    // Inserta una mascota en el sistema
    function add() {
        $name = $_POST['name'];
        $animal_type_id = $_POST['animalType'];
        $city_id = $_POST['city'];
        $gender_id = $_POST['genderType'];
        $date = $_POST['date'];
        $phone_number = $_POST['phone'];
        $photo = $_POST['photo'];
        $description = $_POST['description'];
        $user_id = $_POST['userId'];

        // verifico campos obligatorios
        if (empty($name) || empty($animal_type_id) || empty($city_id) || empty($gender_id) || empty($date) || empty($phone_number) || empty($photo) || empty($user_id)) {
            $this->menuView->showError('Faltan datos obligatorios');
            die();
        }

        // inserto la tarea en la DB
        $id = $this->model->add($name, $animal_type_id, $city_id, $gender_id, $date, $phone_number, $photo, $description, $user_id);

        // redirigimos al listado
        header("Location: " . BASE_URL); 
    }

    // Elimina la mascota del sistema
    function delete($id) {
        $this->model->remove($id);
        header("Location: " . BASE_URL);
    }

    // Finaliza la busqueda de la mascota
    function find($id) {
        $this->model->find($id);
        header("Location: " . BASE_URL);
    }
}
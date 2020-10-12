<?php

include_once 'app/models/pet.model.php';
include_once 'app/views/pet.view.php';
include_once 'app/views/menu.view.php';
include_once 'app/controllers/auth.controller.php';

class PetController {

    private $model;
    private $view;
    private $menuView;

    function __construct() {
        $this->model = new PetModel();
        $this->view = new PetView();
        $this->authController = new AuthController();
        $this->menuView = new MenuView();
    }

    // Muestro las ultimas mascotas perdidas
    function showAllNotFound() {
        $pets = $this->model->getAllNotFound();
        $this->view->showAllNotFound($pets);
    }
    // Muestro las ultimas mascotas perdidas
    function showAllMyPets($userId ) {
        $pets = $this->model->getAllNotFoundByUser($userId );
        $this->view->showAllNotFound($pets);
    }

    // Muestro los filtros en index segun la informacion en la db
    function showPetFilter() {
        $animaltypes = $this->model->getAllAnimalTypes();
        $cities = $this->model->getAllCities();
        $genders = $this->model->getAllGenders();
        $this->view->showPetFilter($animaltypes, $cities, $genders);
    }

    function showAddPetForm($err = null){
        if( $this->authController->isAuth()){
            $this->menuView->showHeader();
            $this->menuView->showNavBar();
            $this->view->showAddPetForm($err);
            $this->menuView->showFooter();
        }else{
            $this->authController->redirectLogin();
        }
    }
    // Muestro las tablas en admin segun la informacion en la db
    function showAdminTables() {
        $animaltypes = $this->model->getAllAnimalTypes();
        $cities = $this->model->getAllCities();
        $this->view->showAdminTables($animaltypes, $cities);
    }

    // Muestro las tablas en categories segun la informacion en la db
    function showCategoriesTables(){
        $animaltypes = $this->model->getAllAnimalTypes();
        $cities = $this->model->getAllCities();
        $genders = $this->model->getAllGenders();
        $this->view->showCategoriesTables($animaltypes, $cities, $genders);
    }

    // Muestro mas informacion de la mascota
    function show($id) {
        $pet = $this->model->get($id);
        if($pet) {
            $this->view->show($pet);
        }
        else {
            $this->menuView->showError('Mascota no encontrada');
        }
    }

    // Filtro mascotas utilizando uno o tres parametros
    function filter(){
        // Me aseguro que haya insertado al menos un dato
        if(isset($_GET["city"]) || isset($_GET["animalType"]) || isset($_GET["gender"])){
            if(isset($_GET["city"])){
                $cityId = $_GET["city"];
            } else $cityId = null;
            if(isset($_GET["animalType"])){
                $animalTypeId = $_GET["animalType"];
            } else $animalTypeId = null;
            if(isset($_GET["gender"])){
                $genderId = $_GET["gender"];
            } else $genderId = null;
            $pets = $this->model->getByFilter($cityId, $animalTypeId, $genderId);
            // Me aseguro que al menos una mascota corresponda con los datos insertados
            if (!empty($pets)){
                $this->view->showByFilter($pets);
            } else{
                $this->menuView->showError('No se encontraron mascotas con esos filtros');
            }
        } else{
            $this->menuView->showError('No insertó ningún dato para filtrar');
        }
    }

    // Inserto una mascota en el sistema
    function add() {
        $name = $_POST['name'];
        if(isset($_POST['animalType'])){
            $animal_type_id = $_POST['animalType'];
        }else{
            $animal_type_id = null;
        }

        if(isset($_POST['animalType'])){
            $city_id = $_POST['city'];
        }else{
            $city_id = null;
        }

        if(isset($_POST['genderType'])){
            $gender_id = $_POST['genderType'];
        }else{
            $gender_id = null;
        }

        $date = $_POST['date'];
        $phone_number = $_POST['phone'];
        $photo = $_POST['photo'];
        $description = $_POST['description'];
       
        //$user_id = $_POST['userId'];

        // verifico campos obligatorios
        if (empty($name) || empty($animal_type_id) || empty($city_id) || empty($gender_id) || empty($date) || empty($phone_number) || empty($photo) || empty($user_id)) {
            $this->showAddPetForm('Faltan datos obligatorios');
            die();
        }

        // inserto la tarea en la DB
        //$id = $this->model->add($name, $animal_type_id, $city_id, $gender_id, $date, $phone_number, $photo, $description, $user_id);

        // redirigimos al listado
        //header("Location: " . BASE_URL); 
    }

    // Elimino la mascota del sistema
    function delete($id) {
        $this->model->remove($id);
        header("Location: " . BASE_URL);
    }

    // Finalizo la busqueda de la mascota
    function find($id) {
        $this->model->find($id);
        header("Location: " . BASE_URL);
    }
}
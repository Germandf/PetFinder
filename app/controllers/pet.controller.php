<?php

include_once 'app/models/pet.model.php';
include_once 'app/models/city.model.php';
include_once 'app/models/gender.model.php';
include_once 'app/models/animaltype.model.php';
include_once 'app/views/pet.view.php';
include_once 'app/views/menu.view.php';
include_once 'app/helpers/auth.helper.php';
include_once 'app/helpers/file.helper.php';

class PetController {

    private $model;
    private $cityModel;
    private $genderModel;
    private $animalTypeModel;
    private $view;
    private $menuView;
    private $authHelper;
    private $fileHelper; 
    
    function __construct() {
        $this->model = new PetModel();
        $this->cityModel = new CityModel();
        $this->genderModel = new GenderModel();
        $this->animalTypeModel = new AnimalTypeModel();
        $this->view = new PetView();
        $this->menuView = new MenuView();
        $this->authHelper = new AuthHelper();
        $this->fileHelper = new FileHelper();
    }

    // Muestro el home
    function showHome(){
        $petCategories = $this->getPetCategories();
        $pets = $this->getAllNotFound();
        $this->view->showHome($petCategories, $pets);
    }

    // Muestro las ultimas mascotas perdidas
    function showMyPets(){
        if($this->authHelper->isAuth()){
            $userId = $this->authHelper->getUserId();
            $pets = $this->model->getAllNotFoundByUser($userId);
            $this->view->showAllMyPets($pets);
        }else{
            $this->authHelper->redirectLogin();
        }
    }

    // Muestro los filtros en index segun la informacion en la db
    function getPetCategories() {
        $animalTypes = $this->animalTypeModel->getAllAnimalTypes();
        $cities = $this->cityModel->getAllCities();
        $genders = $this->genderModel->getAllGenders();
        return [$animalTypes, $cities, $genders];
    }

    // Muestro las ultimas mascotas perdidas
    function getAllNotFound() {
        $pets = $this->model->getAllNotFound();
        return $pets;
    }
    
    function edit($id){
        // Primero obtengo la mascota a partir del ID
        $pet = $this->model->get($id);
        // Obtengo el usuario
        $currentUserId = $this->authHelper->getUserId();
        // Miro si el usuario es dueño o tiene permisos
        if($pet->userId == $currentUserId || $this->authHelper->isAdmin()){
            $this->showAddPetForm(null, $pet);
        } else{
            $this->menuView->showError("Acceso denegado");
        }
    }

    function showAddPetForm($err = null, $pet = null){
        if($this->authHelper->isAuth()){
            //Obtengo los generos y las ciudades
            $petCategories = $this->getPetCategories();
            $this->view->showAddPetForm($err, $petCategories, $pet);
        } else{
            $this->authHelper->redirectLogin();
        }
    }

    // Muestro las tablas en admin segun la informacion en la db
    function showAdminTables() {
        $animalTypes = $this->animalTypeModel->getAllAnimalTypes();
        $cities = $this->cityModel->getAllCities();
        $this->view->showAdminTables($animalTypes, $cities);
    }

    // Muestro las tablas en categories segun la informacion en la db
    function showCategories(){
        $petCategories = $this->getPetCategories();
        $this->view->showCategories($petCategories);
    }

    // Muestro todas las mascotas que correspondan con el filtro // Filtro mascotas utilizando uno o tres parametros
    function showFilterPets(){
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
                $petCategories = $this->getPetCategories();
                $this->view->showByFilter($petCategories, $pets);
            } else{
                $this->menuView->showError('No se encontraron mascotas con esos filtros');
            }
        } else{
            $this->menuView->showError('No insertó ningún dato para filtrar');
        }
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

    // Actualizo la mascota con los nuevos datos
    function update($id = null){
        if($id == null){
            $this->menuView->showError('No se encontró la mascota para editar');
        } else{
            $pet = $this->model->get($id);
            $currentUserId = $this->authHelper->getUserId();
            if($pet->userId == $currentUserId || $this->authHelper->isAdmin()){
                //Tenemos que mostrar todos los datos en el form
                $this->add($pet);
                $this->showAddPetForm(null, $pet); //Estamos editando
            }else{
                $this->menuView->showError('Acceso denegado');
            }
        }
    }

    // Inserto una mascota en el sistema o edito una
    function add($pet = null) {
        $animal_type_id = isset($_POST['animalType']) ? $_POST['animalType'] : null;
        $city_id = isset($_POST['city']) ? $_POST['city'] : null;
        $gender_id = isset($_POST['animalType']) ? $_POST['animalType'] : null;
        if(isset($_FILES['photo'])){
            $photo = $_FILES['photo'];
            // Compruebo si estamos editando y no envio foto
            if($pet != null && $photo['size'] == 0) 
                // A foto le asigno la URL que ya tenemos en la base de datos
                $photo = $pet->photo;
        }else{
            $photo = null;
        }
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $date = isset($_POST['date']) ? $_POST['date'] : null;
        $phone_number = isset($_POST['phone']) ? $_POST['phone'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;
        // Obtengo el usuario que esta subiendo la mascota
        $user_id = $this->authHelper->getUserId();
        
        // Verifico campos obligatorios
        if (empty($name) || empty($animal_type_id) || empty($city_id) || empty($gender_id) || empty($date) || empty($phone_number) || empty($photo) || empty($user_id)) {
            $this->showAddPetForm('Faltan datos obligatorios');
            die();
        }
        // Detecto si estamos subiendo una foto
        if($_FILES['photo']['size']>0){
            // Devuelve la ruta de la foto una vez que se subio o false en caso de que no
            $resultImageUpload = $this->fileHelper->uploadImage('photo');
            // Si no se subio
            if(!$resultImageUpload){
                $this->showAddPetForm('Ocurrio un error en el servidor');
                die();
            }
            // Si se subio
            else{
                // Si no estoy editando
                if($pet == null){
                    $id = $this->model->add($name, $animal_type_id, $city_id, $gender_id, $date, $phone_number, $resultImageUpload, $description, $user_id);
                    if($id!=0){
                        $this->authHelper->redirectHome();
                    }
                }
                // Si estoy editando
                else{
                    $this->model->update($pet->id, $name, $animal_type_id, $city_id, $gender_id, $date, $phone_number, $resultImageUpload, $description);
                }
            }
        }
        // Si no estamos subiendo una foto y estamos editando
        elseif($pet != null){
            $this->model->update($pet->id, $name, $animal_type_id, $city_id, $gender_id, $date, $phone_number, $photo, $description);
        }
        // Si estamos editando, redirige a editar con los datos actualizados
        if($pet != null){
            header("Location: ".BASE_URL.'mis-mascotas'); 
        }
        // Si no estamos editando, volvemos al inicio
        else{
            header("Location: " . BASE_URL);
        }
    }

    // Elimino la mascota del sistema
    function delete($id) {
        $pet = $this->model->get($id);
        $currentUserId = $this->authHelper->getUserId();
        if($pet){
            if($pet->userId == $currentUserId || $this->authHelper->isAdmin()){
                // Eliminamos
                $this->model->remove($id);
                header("Location: " . BASE_URL);
            }else{
                $this->menuView->showError('Acceso denegado');
            }
        } else{
            $this->menuView->showError('No se encontró la mascota');
        }
    }

    // Finalizo la busqueda de la mascota
    function setFound($id) {
        $pet = $this->model->get($id);
        $currentUserId = $this->authHelper->getUserId();
        if($pet){
            if($pet->userId == $currentUserId || $this->authHelper->isAdmin()){
                // Encontramos
                $this->model->setFound($id);
                header("Location: " . BASE_URL);
            }else{
                $this->menuView->showError('Acceso denegado');
            }
        } else{
            $this->menuView->showError('No se encontró la mascota');
        }
    }

    // Cargo la pagina admin
    function showAdmin(){
        if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
            $petCategories = $this->getPetCategories();
            $pets = $this->getAllNotFound();
            $this->view->showAdminPage($petCategories, $pets);
        }else{
            $this->menuView->showError("Acceso denegado");
        }
    }
}
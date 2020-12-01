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

    // Muestro el home a partir de x cantidad de mascotas
    function showHome($amount = 0){
        if($amount < 0 || !is_numeric($amount)){
            $amount = 0;
        }
        $petCategories = $this->getPetCategories();
        $pets = $this->getAllNotFound();
        $petsToShow = array_slice($pets, $amount, 12);
        $this->view->showHome($petCategories, $pets, $petsToShow, $amount);
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
            $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
        }
    }

    // Muestra formulario de agregar mascota
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

    // Muestro todas las mascotas que correspondan con el filtro utilizando uno o tres parametros
    function showByFilter($amount = 0){
        // Me aseguro que haya insertado al menos un dato
        if(isset($_GET["city"]) || isset($_GET["animalType"]) || isset($_GET["gender"]) || isset($_GET["search"])){
            $cityId = isset($_GET['city']) ? $_GET['city'] : null;
            $animalTypeId = isset($_GET['animalType']) ? $_GET['animalType'] : null;
            $genderId = isset($_GET['gender']) ? $_GET['gender'] : null;
            $search = isset($_GET['search']) ? $_GET['search'] : null;
            $pets = $this->model->getByFilter($cityId, $animalTypeId, $genderId, $search);
            // Me aseguro que al menos una mascota corresponda con los datos insertados
            if (!empty($pets)){
                if($amount < 0 || !is_numeric($amount)){
                    $amount = 0;
                }
                $petCategories = $this->getPetCategories();
                $petsToShow = array_slice($pets, $amount, 12);
                $query = http_build_query(array('city'=>$cityId, 'animalType'=>$animalTypeId, 'gender'=>$genderId, 'buscar'=>$search));
                $this->view->showByFilter($petCategories, $pets, $petsToShow, $amount, $query);
            } else{
                $this->menuView->showError(FILTERED_PETS_NOT_FOUND, FILTERED_PETS_NOT_FOUND_MSG);
            }
        } else{
            $this->menuView->showError(FILTERS_MISSING, FILTERS_MISSING_MSG);
        }
    }

    // Muestro mas informacion de la mascota
    function show($id) {
        $pet = $this->model->get($id);
        if($pet) {
            $this->view->show($pet);
        }
        else {
            $this->menuView->showError(PET_NOT_FOUND, PET_NOT_FOUND_MSG);
        }
    }

    // Actualizo la mascota con los nuevos datos
    function update($id = null){
        if($id == null){
            $this->menuView->showError(PET_NOT_FOUND, PET_NOT_FOUND_MSG);
        } else{
            $pet = $this->model->get($id);
            $currentUserId = $this->authHelper->getUserId();
            if($pet->userId == $currentUserId || $this->authHelper->isAdmin()){
                $this->add($pet);
            }else{
                $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
            }
        }
    }

    // Inserto una mascota en el sistema o edito una
    function add($pet = null) {
        $animal_type_id = isset($_POST['animalType']) ? $_POST['animalType'] : null;
        $city_id = isset($_POST['city']) ? $_POST['city'] : null;
        $gender_id = isset($_POST['gender']) ? $_POST['gender'] : null;
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
            $this->showAddPetForm(DATA_MISSING);
            return;
        }
        // Detecto si estamos subiendo una foto
        if($_FILES['photo']['size']>0){
            // Devuelve la ruta de la foto una vez que se subio o false en caso de que no
            $resultImageUpload = $this->fileHelper->uploadImage('photo');
            // Si no se subio
            if(!$resultImageUpload){
                $this->showAddPetForm("Error al subir la imagen, asegúrese que la extensión sea compatible");
                return;
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
        // Si estamos editando, redirige a mis mascotas
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
                $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
            }
        } else{
            $this->menuView->showError(PET_NOT_FOUND, PET_NOT_FOUND_MSG);
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
                $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
            }
        } else{
            $this->menuView->showError(PET_NOT_FOUND, PET_NOT_FOUND_MSG);
        }
    }

    // Cargo la pagina admin
    function showAdmin($amount = 0){
        if($this->authHelper->isAuth() && $this->authHelper->isAdmin()){
            if($amount < 0 || !is_numeric($amount)){
                $amount = 0;
            }
            $petCategories = $this->getPetCategories();
            $pets = $this->getAllNotFound();
            $petsToShow = array_slice($pets, $amount, 12);
            $this->view->showAdminPage($petCategories, $pets, $petsToShow, $amount);
        }else{
            $this->menuView->showError(ACCESS_DENIED, ACCESS_DENIED_MSG);
        }
    }
}
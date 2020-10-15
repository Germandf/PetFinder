<?php

include_once 'app/models/pet.model.php';
include_once 'app/models/city.model.php';
include_once 'app/models/gender.model.php';
include_once 'app/models/animaltype.model.php';

include_once 'app/views/pet.view.php';
include_once 'app/views/menu.view.php';

include_once 'app/controllers/auth.controller.php';
include_once 'app/controllers/file.controller.php';

class PetController {

    private $model;
    private $cityModel;
    private $genderModel;
    private $animalTypeModel;

    private $view;
    private $menuView;

    private $authController;
    private $fileController; 
    
    function __construct() {
        $this->model = new PetModel();
        $this->view = new PetView();
        $this->authController = new AuthController();
        $this->menuView = new MenuView();
        $this->cityModel = new CityModel();
        $this->genderModel = new GenderModel();
        $this->animalTypeModel = new AnimalTypeModel();
        $this->fileController = new FileController();
    }

    // Muestro las ultimas mascotas perdidas
    function showAllNotFound() {
        $pets = $this->model->getAllNotFound();
        $this->view->showAllNotFound($pets);
    }

    // Muestro las ultimas mascotas perdidas
    function showAllMyPets($userId) {
        $pets = $this->model->getAllNotFoundByUser($userId);
        $this->view->showAllMyPets($pets);
    }

    // Muestro los filtros en index segun la informacion en la db
    function showPetFilter() {
        $animaltypes = $this->animalTypeModel->getAllAnimalTypes();
        $cities = $this->cityModel->getAllCities();
        $genders = $this->genderModel->getAllGenders();
        $this->view->showPetFilter($animaltypes, $cities, $genders);
    }
    
    function edit($id){
        // Primero obtengo la mascota a partir del ID
        $pet = $this->model->get($id);
        // Obtengo el usuario
        $currentUserId = $this->authController->getUserId();
        // Miro si el usuario es dueño o tiene permisos
        if($pet->userId == $currentUserId || $this->authController->isAdmin()){
            $this->showAddPetForm(null, $pet);
        } else{
            $menuController = new MenuController();
            $menuController->showAccessDenied();
        }
    }

    function showAddPetForm($err = null, $pet = null){
        if($this->authController->isAuth()){
            $this->menuView->showHeader();
            $this->menuView->showNavBar();
            //Obtengo los generos y las ciudades
            $cities = $this->cityModel->getAllCities();
            $genders = $this->genderModel->getAllGenders();
            $animalTypes = $this->animalTypeModel->getAllAnimalTypes();
            $this->view->showAddPetForm($err, $cities, $genders, $animalTypes, $pet);
            $this->menuView->showFooter();
        } else{
            $this->authController->redirectLogin();
        }
    }

    // Muestro las tablas en admin segun la informacion en la db
    function showAdminTables() {
        $animalTypes = $this->animalTypeModel->getAllAnimalTypes();
        $cities = $this->cityModel->getAllCities();
        $this->view->showAdminTables($animalTypes, $cities);
    }

    // Muestro las tablas en categories segun la informacion en la db
    function showCategoriesTables(){
        $animalTypes = $this->animalTypeModel->getAllAnimalTypes();
        $cities = $this->cityModel->getAllCities();
        $genders = $this->genderModel->getAllGenders();
        $this->view->showCategoriesTables($animalTypes, $cities, $genders);
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

    function update($id){
        $pet = $this->model->get($id);
        $currentUserId = $this->authController->getUserId();
        if($pet->userId == $currentUserId || $this->authController->isAdmin()){
            //Tenemos que mostrar todos los datos en el form
            
            $this->add($pet);
            $this->showAddPetForm(null, $pet); //Estamos editando
        }else{
            $menuController = new MenuController();
            $menuController->showAccessDenied();
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

    // Inserto una mascota en el sistema o edito una
    function add($pet = null) {
        if(isset($_POST['animalType'])){
            $animal_type_id = $_POST['animalType'];
        }else{
            $animal_type_id = null;
        }
        if(isset($_POST['city'])){
            $city_id = $_POST['city'];
        }else{
            $city_id = null;
        }
        if(isset($_POST['genderType'])){
            $gender_id = $_POST['genderType'];
        }else{
            $gender_id = null;
        }
        if(isset($_FILES['photo'])){
            $photo = $_FILES['photo'];
            // Compruebo si estamos editando y no envio foto
            if($pet != null && $photo['size'] == 0) 
                // A foto le asigno la URL que ya tenemos en la base de datos
                $photo = $pet->photo;
        }else{
            $photo = null;
        }
        $name = $_POST['name'];
        $date = $_POST['date'];
        $phone_number = $_POST['phone'];
        $description = $_POST['description'];
        $user_id = $this->authController->getUserId();

        // Verifico campos obligatorios
        if (empty($name) || empty($animal_type_id) || empty($city_id) || empty($gender_id) || empty($date) || empty($phone_number) || empty($photo) || empty($user_id)) {
            $this->showAddPetForm('Faltan datos obligatorios');
            die();
        }
        // Detecto si estamos subiendo una foto
        if($_FILES['photo']['size']>0){
            // Devuelve la ruta de la foto una vez que se subio o false en caso de que no
            $resultImageUpload = $this->fileController->uploadImage('photo');
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
                        $this->authController->redirectHome();
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
        $this->model->remove($id);
        header("Location: " . BASE_URL);
    }

    // Finalizo la busqueda de la mascota
    function find($id) {
        $this->model->find($id);
        header("Location: " . BASE_URL);
    }
}
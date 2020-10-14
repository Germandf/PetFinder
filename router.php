<?php

include_once('app/controllers/menu.controller.php');
include_once('app/controllers/auth.controller.php');
include_once('app/controllers/user.controller.php');

// defino la base url para la construccion de links con urls semánticas
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

// lee la acción
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'home'; // acción por defecto si no envían
}

// parsea la accion Ej: suma/1/2 --> ['suma', 1, 2]
$params = explode('/', $action);

// determina que camino seguir según la acción
switch ($params[0]) {
    case 'home':
        $controller = new MenuController();
        $controller->showHome();
        break;
    case 'login':
        $controller = new MenuController();
        $controller->showLogin();
        break;
    case 'signup':
        $controller = new MenuController();
        $controller->showSignup();
        break;
    case 'adduser':
        $controller = new UserController();
        $controller->adduser();
    break;
    case 'verify':
        $controller = new AuthController();
        $controller->logIn();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logOut();
        break;
    case 'my-pets':
        $controller = new MenuController();
        $controller->showMyPets();
        break;
    break;
    case 'admin':
        $controller = new MenuController();
        $controller->showAdmin();
        break;
    case 'categorias':
        $controller = new MenuController();
        $controller->showCategories();
        break;
    case 'about':
        $controller = new MenuController();
        $controller->showAbout();
        break;
    case 'agregar':
        $controller = new PetController();
        $controller->showAddPetForm();
        break;
    case 'insertar-mascota':
        $controller = new PetController();
        $controller->add();
        break;
    case 'editar':
        $controller = new PetController();
        $idMascota = $params[1];
        $controller->edit($idMascota);
        break;
        
    case 'actualizar-mascota':
        $controller = new PetController();
        $idMascota = $params[1];
        $controller->update($idMascota);
        break;
    case 'eliminar':
        $controller = new PetController();
        $id = $params[1];
        $controller->delete($id);
        break;
    case 'encontrar':
        $controller = new PetController();
        $id = $params[1];
        $controller->find($id);
        break;
    case 'ver':
        $controller = new MenuController();
        $id = $params[1];
        $controller->showPet($id);
        break;
    case 'filtrar':
        $controller = new MenuController();
        $controller->showFilterPets();
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo('404 Page not found');
        break;
}
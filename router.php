<?php

include_once('app/controllers/pet.controller.php');

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
        $menu = new PetController();
        $menu->showHome();
        break;
    case 'admin':
        $menu = new PetController();
        $menu->showAdmin();
        break;
    case 'categorias':
        $menu = new PetController();
        $menu->showCategories();
        break;
    case 'about':
        $menu = new PetController();
        $menu->showAbout();
        break;
    case 'login':
        $menu = new PetController();
        $menu->showLogin();
        break;
    case 'signup':
        $menu = new PetController();
        $menu->showSignup();
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo('404 Page not found');
        break;
}
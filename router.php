<?php

include_once('app/controllers/menu.controller.php');

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
    case 'login':
        $controller = new MenuController();
        $controller->showLogin();
        break;
    case 'signup':
        $controller = new MenuController();
        $controller->showSignup();
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo('404 Page not found');
        break;
}
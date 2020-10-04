<?php

// defino la base url para la construccion de links con urls semánticas
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

/* El menu esta pensado para ser el controlador 
que "navega" entre las diferentes secciones */
include_once('app/controllers/menu.controller.php');
$menu = new  MenuController();
// lee la acción
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'listar'; // acción por defecto si no envían
}

// parsea la accion Ej: suma/1/2 --> ['suma', 1, 2]
$params = explode('/', $action);

// determina que camino seguir según la acción
switch ($params[0]) {
    case 'index':
        $menu->showNavBar();
        break;
    case 'admin':
        echo('Admin');
        break;
    case 'categories':
        echo('Categories');
        break;
    case 'about':
        echo('About');
        break;
    case 'login':
        echo('Login');
        break;
    case 'signup':
        echo('Signup');
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo('404 Page not found');
        break;
}

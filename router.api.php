<?php
require_once 'libs/Router.php';
require_once 'app/api/api.comment.controller.php';
require_once 'app/api/api.auth.jwt.controller.php';

// Creo el router
$router = new Router();

// Armo la tabla de ruteo
$router->addRoute('comentario/:ID', 'GET', 'ApiCommentController', 'get');

$router->addRoute('comentarios', 'GET', 'ApiCommentController', 'getAll');
$router->addRoute('comentarios/:ID', 'GET', 'ApiCommentController', 'getFromPet');
$router->addRoute('comentarios', 'POST', 'ApiCommentController', 'add');
$router->addRoute('comentarios/:ID', 'DELETE', 'ApiCommentController', 'delete');
$router->addRoute('auth', 'POST', 'AuthJwtController', 'signIn');

$router->setDefaultRoute('ApiCommentController','show404');

// Ruteo
$router->route($_REQUEST['resource'], $_SERVER['REQUEST_METHOD']);
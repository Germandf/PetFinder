<?php

// Settings
define("DB_HOST", "localhost");
define("DB_NAME", "petfinder");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("ADMIN_PERMISSION", "1");
define("USER_PERMISSION", "2");
define("DEBUG_MODE", true);
define("SECRET_KEY", "qNc#eA3_R@LW;]kR");
define("EXP_TIME", 60 * 60 * 24 * 15); //Expira en 15 días

// Mensajes de error

define("DATA_MISSING", "Faltan datos obligatorios");
define("DATA_MISSING_MSG", "Asegúrese de llenar todos los campos");
define("SERVER_ERROR", "Ocurrió un error en el servidor");
define("SERVER_ERROR_MSG", "Intente nuevamente más tarde o póngase en contacto con los administradores");
define("NOT_FOUND", "404 Not Found");
define("NOT_FOUND_MSG", "El recurso solicitado no existe o no está disponible");
define("ACCESS_DENIED", "Acceso denegado");
define("ACCESS_DENIED_MSG", "No tiene permisos para acceder a este contenido");

define("USER_NOT_FOUND", "No se encontró el usuario");
define("USER_NOT_FOUND_MSG", "El usuario solicitado no existe o no está disponible, quizás escribió mal la dirección");

define("ANIMAL_TYPE_EXISTS", "Este tipo de animal ya existe");
define("ANIMAL_TYPE_EXISTS_MSG", "Pruebe de ingresar un nombre diferente");
define("ANIMAL_TYPE_NOT_FOUND", "No se encontró el tipo de animal");
define("ANIMAL_TYPE_NOT_FOUND_MSG", "El tipo de animal solicitado no existe o no está disponible, quizás escribió mal la dirección");

define("CITY_EXISTS", "Esta ciudad ya existe");
define("CITY_EXISTS_MSG", "Pruebe de ingresar un nombre diferente");
define("CITY_NOT_FOUND", "No se encontró la ciudad");
define("CITY_NOT_FOUND_MSG", "La ciudad solicitada no existe o no está disponible, quizás escribió mal la dirección");

define("PET_NOT_FOUND", "Mascota no encontrada");
define("PET_NOT_FOUND_MSG", "La mascota solicitada no existe o no está disponible, quizás escribió mal la dirección");
define("FILTERED_PETS_NOT_FOUND", "No se encontraron mascotas con esos filtros");
define("FILTERED_PETS_NOT_FOUND_MSG", "Pruebe de utilizar filtros diferentes");
define("FILTERS_MISSING", "No insertó datos para filtrar");
define("FILTERS_MISSING_MSG", "Asegúrese de seleccionarlos haciendo click en Ciudad, Tipo de Mascota o Género");
<?php

include_once 'app/helpers/config.php';

class CityModel {
    
    private $db;

    function __construct() {
        $this->db = $this->connect();
    }

    // Abre conexión a la base de datos
    private function connect() {
        $db = new PDO('mysql:host='.DB_HOST.';'.'dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
        return $db;
    }

    // Obtiene todos los generos de la base de datos
    function getAllGenders(){
        $query = $this->db->prepare('SELECT * FROM gender');
        $query->execute();
        $genders = $query->fetchAll(PDO::FETCH_OBJ);
        return $genders;
    }

    // Obtiene todas las ciudades disponibles de la base de datos
    function getAllCities(){
        $query = $this->db->prepare('SELECT * FROM city');
        $query->execute();
        $cities = $query->fetchAll(PDO::FETCH_OBJ);
        return $cities;
    }
}

<?php

include_once 'app/helpers/config.php';

class AnimalTypeModel {
    
    private $db;

    function __construct() {
        $this->db = $this->connect();
    }

    // Abre conexión a la base de datos
    private function connect() {
        $db = new PDO('mysql:host='.DB_HOST.';'.'dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
        return $db;
    }

    // Obtiene todos los tipos de anymales
    function getAllAnimalTypes(){
        $query = $this->db->prepare('SELECT * FROM animal_type');
        $query->execute();
        $genders = $query->fetchAll(PDO::FETCH_OBJ);
        return $genders;
    }
}
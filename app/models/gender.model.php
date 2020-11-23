<?php

include_once 'app/helpers/db.helper.php';

class GenderModel {
    
    private $db;
    private $dbHelper;

    function __construct() {
        $this->dbHelper = new DbHelper();
        $this->db = $this->dbHelper->connect();
    }

    // Obtiene todos los generos de la base de datos
    function getAllGenders(){
        $query = $this->db->prepare('SELECT * FROM gender');
        $query->execute();
        $genders = $query->fetchAll(PDO::FETCH_OBJ);
        return $genders;
    }
}

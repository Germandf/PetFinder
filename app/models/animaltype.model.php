<?php

include_once 'app/helpers/db.helper.php';

class AnimalTypeModel {
    
    private $dbHelper;
    private $db;

    function __construct() {
        $this->dbHelper = new DbHelper();
        $this->db = $this->dbHelper->connect();
    }

    // Obtengo un tipo de animal de la base de datos
    function get($id) {
        $query = $this->db->prepare('   SELECT * 
                                        FROM animal_type
                                        WHERE `id` = ?');
        $query->execute([$id]);
        $animalType = $query->fetch(PDO::FETCH_OBJ);
        return $animalType;
    }

    // Obtiene todos los tipos de animales
    function getAllAnimalTypes(){
        $query = $this->db->prepare('SELECT * FROM animal_type');
        $query->execute();
        $animalTypes = $query->fetchAll(PDO::FETCH_OBJ);
        return $animalTypes;
    }

    // Inserta el tipo de animal en la base de datos
    function add($name) {
        $query = $this->db->prepare('   INSERT INTO animal_type (`name`) 
                                        VALUES (?)');
        $query->execute([$name]);
        // Obtengo y devuelvo el ID del tipo de animal nuevo
        return $this->db->lastInsertId();
    }
    
    // Actualiza los datos de un tipo de animal en la base de datos
    function update($name, $id) {
        $query = $this->db->prepare('   UPDATE `animal_type` 
                                        SET `name`= ?
                                        WHERE `animal_type`.`id` = ?');
        $result = $query->execute([$name, $id]);
        return $result;
    }

    // Elimina el tipo de animal de la base de datos
    function remove($id) {
        $query = $this->db->prepare('DELETE FROM animal_type WHERE id = ?');
        $query->execute([$id]);
    }

    function animalTypeExists($name){
        $query = $this->db->prepare('SELECT id FROM animal_type WHERE `name` = ?');
        $result = $query->execute([$name]);
        $row = $query->fetchAll(PDO::FETCH_OBJ);
        return count($row); //Si encontro alguna ciudad devuelve true
    }
}
<?php

include_once 'app/helpers/db.helper.php';

class CityModel {
    
    private $db;
    private $dbHelper;

    function __construct() {
        $this->dbHelper = new DbHelper();
        $this->db = $this->dbHelper->connect();
    }

    // Obtengo una ciudad de la base de datos
    function get($id) {
        $query = $this->db->prepare('   SELECT * 
                                        FROM city
                                        WHERE `id` = ?');
        $query->execute([$id]);
        $city = $query->fetch(PDO::FETCH_OBJ);
        return $city;
    }

    // Obtiene todas las ciudades disponibles de la base de datos
    function getAllCities(){
        $query = $this->db->prepare('SELECT * FROM city');
        $query->execute();
        $cities = $query->fetchAll(PDO::FETCH_OBJ);
        return $cities;
    }

    // Inserta la ciudad en la base de datos
    function add($name) {
        $query = $this->db->prepare('   INSERT INTO city (`name`) 
                                        VALUES (?)');
        $query->execute([$name]);
        // Obtengo y devuelvo el ID de la ciudad nueva
        return $this->db->lastInsertId();
    }
    
   
    // Actualiza los datos de una ciudad en la base de datos
    function update($name, $id) {
        $query = $this->db->prepare('   UPDATE `city` 
                                        SET `name`= ?
                                        WHERE `city`.`id` = ?');
        $result = $query->execute([$name, $id]);
        return $result;
    }

    // Elimina la ciudad de la base de datos
    function remove($id) {
        $query = $this->db->prepare('DELETE FROM city WHERE id = ?');
        $query->execute([$id]);
    }

    function cityExists($name){
        $query = $this->db->prepare('SELECT id FROM city WHERE `name` = ?');
        $result = $query->execute([$name]);
        $row = $query->fetchAll(PDO::FETCH_OBJ);
        return count($row); //Si encontro alguna ciudad devuelve true
    }
}

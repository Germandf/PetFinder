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
        print_r([$name, $id]);
        return $result;
    }

    // Elimina la ciudad de la base de datos
    function remove($id) {
        $query = $this->db->prepare('DELETE FROM city WHERE id = ?');
        $query->execute([$id]);
    }
}

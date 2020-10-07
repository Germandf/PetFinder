<?php

include_once 'app/helpers/config.php';

class PetModel {

    private $db;

    function __construct() {
        $this->db = $this->connect();
    }

    // Abre conexión a la base de datos
    private function connect() {
        $db = new PDO('mysql:host='.DB_HOST.';'.'dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
        return $db;
    }

    // Devuelve todas las mascotas sin encontrar de la base de datos
    function getAllNotFound() {
        $query = $this->db->prepare('SELECT * FROM pet WHERE found = 0');
        $query->execute();
        $pets = $query->fetchAll(PDO::FETCH_OBJ);
        return $pets;
    }

    // Devuelve todas las mascotas encontradas de la base de datos
    function getAllFound() {
        $query = $this->db->prepare('SELECT * FROM pet WHERE found = 1');
        $query->execute();
        $pets = $query->fetchAll(PDO::FETCH_OBJ);
        return $pets;
    }

    // Obtengo una mascota de la base de datos
    function get($id) {
        $query = $this->db->prepare('SELECT * FROM pet WHERE id = ?');
        $query->execute([$id]);
        $pet = $query->fetch(PDO::FETCH_OBJ);
        return $pet;
    }

    // Inserta la mascota en la base de datos
    function add($name, $animal_type_id, $city_id, $gender_id, $date, $phone_number, $photo, $description, $user_id) {
        $query = $this->db->prepare('   INSERT INTO pet (`name`, `animal_type_id`, `city_id`, `gender_id`, `date`, `phone_number`, `photo`, `description`, `user_id`) 
                                        VALUES (?,?,?,?,?,?,?,?,?)');
        $query->execute([$name, $animal_type_id, $city_id, $gender_id, $date, $phone_number, $photo, $description, $user_id]);
        // Obtengo y devuelvo el ID de la mascota nueva
        return $this->db->lastInsertId();
    }

    // Elimina la mascota de la base de datos
    function remove($id) {
        $query = $this->db->prepare('DELETE FROM pet WHERE id = ?');
        $query->execute([$id]);
    }

    // Finaliza la busqueda de la mascota
    function find($id) {
        $query = $this->db->prepare('UPDATE pet SET found = 1 WHERE id = ?');
        $query->execute([$id]);
    }
}
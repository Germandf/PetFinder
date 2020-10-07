<?php

class PetModel {

    private $db;

    function __construct() {
        $this->db = $this->connect();
    }

    // Abre conexión a la base de datos
    private function connect() {
        $db = new PDO('mysql:host=localhost;'.'dbname=petfinder;charset=utf8', 'root', '');                 //¡¡CORREGIR!!
        return $db;
    }

    // Devuelve todas las mascotas de la base de datos
    function getAll() {

        // Envio la consulta
        $query = $this->db->prepare('SELECT * FROM lost_pets');                                             //¡¡CORREGIR!!
        $query->execute();

        // Obtengo conjunto de respuestas con un fetchAll
        $pets = $query->fetchAll(PDO::FETCH_OBJ);

        return $pets;
    }

    // Obtengo una mascota de la base de datos
    function get($id) {
        $query = $this->db->prepare('SELECT * FROM lost_pets WHERE id = ?');                                //¡¡CORREGIR!!
        $query->execute([$id]);
        $pet = $query->fetch(PDO::FETCH_OBJ);
        return $pet;
    }

    // Inserta la mascota en la base de datos
    function insert($id, $name, $animal_type_id, $city_id, $lost_type_id, $gender_id, $date, $phone_number, $photo, $description, $user_id) {                                                    //¡¡CORREGIR!!

        // Envio la consulta
        $query = $this->db->prepare('INSERT INTO lost_pets (`id`, `name`, `animal_type_id`, `city_id`, `lost_type_id`, `gender_id`, `date`, `phone_number`, `photo`, `description`, `user_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?)');  //¡¡CORREGIR!!
        $query->execute([$id, $name, $animal_type_id, $city_id, $lost_type_id, $gender_id, $date, $phone_number, $photo, $description, $user_id]);                                               //¡¡CORREGIR!!

        // Obtengo y devuelo el ID de la mascota nueva
        return $this->db->lastInsertId();
    }

    // Elimina la mascota de la base de datos
    function remove($id) {  
        $query = $this->db->prepare('DELETE FROM lost_pets WHERE id = ?');                                  //¡¡CORREGIR!!
        $query->execute([$id]);
    }

    // Finaliza la busqueda de la mascota
    function finalize($id) {
        $query = $this->db->prepare('UPDATE lost_pets SET founded = 1 WHERE id = ?');                       //¡¡CORREGIR!!
        $query->execute([$id]);
    }
}
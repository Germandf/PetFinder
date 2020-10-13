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
        $query = $this->db->prepare('   SELECT p.`id`, p.`name`, a.`name` as `animalType`, c.`name` as `city`, g.`name` as `gender`, p.`date`, p.`phone_number` as `phoneNumber`, p.`photo`, p.`description`, u.`id` as `userId`, p.`found`
                                        FROM `pet` as `p`
                                        INNER JOIN `animal_type` as `a` ON `p`.`animal_type_id` = `a`.`id`
                                        INNER JOIN `city` as `c` ON `p`.`city_id` = `c`.`id`
                                        INNER JOIN `gender` as `g` ON `p`.`gender_id` = `g`.`id`
                                        INNER JOIN `user` as `u` ON `p`.`user_id` = `u`.`id`
                                        WHERE p.`found` = 0
                                        ');
        $query->execute();
        $pets = $query->fetchAll(PDO::FETCH_OBJ);
        return $pets;
    }

    // Devuelve todas las mascotas de un usuario sin encontrar de la base de datos
    function getAllNotFoundByUser($userId) {
        $query = $this->db->prepare('   SELECT p.`id`, p.`name`, a.`name` as `animalType`, c.`name` as `city`, g.`name` as `gender`, p.`date`, p.`phone_number` as `phoneNumber`, p.`photo`, p.`description`, u.`id` as `userId`, p.`found`
                                        FROM `pet` as `p`
                                        INNER JOIN `animal_type` as `a` ON `p`.`animal_type_id` = `a`.`id`
                                        INNER JOIN `city` as `c` ON `p`.`city_id` = `c`.`id`
                                        INNER JOIN `gender` as `g` ON `p`.`gender_id` = `g`.`id`
                                        INNER JOIN `user` as `u` ON `p`.`user_id` = `u`.`id`
                                        WHERE p.`found` = 0 AND  u.`id` = ?
                                        ');
        $query->execute([$userId]);
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
        $query = $this->db->prepare('   SELECT p.`id`, p.`name`, a.`name` as `animalType`, c.`name` as `city`, g.`name` as `gender`, p.`date`, p.`phone_number` as `phoneNumber`, p.`photo`, p.`description`, u.`id` as `userId`, u.`name` as `userName`, u.`email` as `userEmail`, p.`found`
                                        FROM `pet` as `p`
                                        INNER JOIN `animal_type` as `a` ON `p`.`animal_type_id` = `a`.`id`
                                        INNER JOIN `city` as `c` ON `p`.`city_id` = `c`.`id`
                                        INNER JOIN `gender` as `g` ON `p`.`gender_id` = `g`.`id`
                                        INNER JOIN `user` as `u` ON `p`.`user_id` = `u`.`id`
                                        WHERE p.`id` = ?');
        $query->execute([$id]);
        $pet = $query->fetch(PDO::FETCH_OBJ);
        return $pet;
    }

    // Obtiene un arreglo de mascotas a partir de los datos insertados en el filtro
    function getByFilter($cityId = null, $animalTypeId = null, $genderId = null){
        $query = $this->db->prepare('   SELECT p.`id`, p.`name`, a.`name` as `animalType`, c.`name` as `city`, g.`name` as `gender`, p.`date`, p.`phone_number` as `phoneNumber`, p.`photo`, p.`description`, u.`id` as `userId`, u.`name` as `userName`, u.`email` as `userEmail`, p.`found`, c.`id` as `cityId`, a.`id` as `animalTypeId`, g.`id` as `genderId`
                                        FROM `pet` as `p`
                                        INNER JOIN `animal_type` as `a` ON `p`.`animal_type_id` = `a`.`id`
                                        INNER JOIN `city` as `c` ON `p`.`city_id` = `c`.`id`
                                        INNER JOIN `gender` as `g` ON `p`.`gender_id` = `g`.`id`
                                        INNER JOIN `user` as `u` ON `p`.`user_id` = `u`.`id`
                                        WHERE c.`id` = IFNULL(?, c.`id`)
                                        AND a.`id` = IFNULL(?, a.`id`)
                                        AND g.`id` = IFNULL(?, g.`id`)');
        $query->execute([$cityId, $animalTypeId, $genderId]);
        $pets = $query->fetchAll(PDO::FETCH_OBJ);
        return $pets;
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
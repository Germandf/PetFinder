<?php

include_once 'app/helpers/db.helper.php';

class PetModel {

    private $db;
    private $dbHelper;

    function __construct() {
        $this->dbHelper = new DbHelper();
        $this->db = $this->dbHelper->connect();
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

    // Devuelve todas las mascotas de un usuario de la base de datos
    function getAllByUser($userId){
        $query = $this->db->prepare('SELECT * FROM `pet` WHERE `user_id`= ?');
        $query->execute([$userId]);
        return $query->fetchAll(PDO::FETCH_OBJ);
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
                                        AND g.`id` = IFNULL(?, g.`id`)
                                        AND p.`found` = 0');
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

    // Actualiza los datos de una mascota en la base de datos
    function update($id, $name, $animal_type_id, $city_id, $gender_id, $date, $phone_number, $photo, $description) {
        $query = $this->db->prepare('   UPDATE `pet` 
                                        SET `name`=?, `animal_type_id`=?, `city_id`=?, `gender_id` = ?, `date` = ?, `phone_number`=?, `photo` = ?, `description` = ?  
                                        WHERE `pet`.`id` = ?');
        $result = $query->execute([$name, $animal_type_id, $city_id, $gender_id, $date, $phone_number, $photo, $description, $id]);
        return $result;
    }

    // Elimina la mascota de la base de datos
    function remove($id) {
        $query = $this->db->prepare('DELETE FROM pet WHERE id = ?');
        $query->execute([$id]);
    }

    // Finaliza la busqueda de la mascota
    function setFound($id) {
        $query = $this->db->prepare('UPDATE pet SET found = 1 WHERE id = ?');
        $query->execute([$id]);
    }

}
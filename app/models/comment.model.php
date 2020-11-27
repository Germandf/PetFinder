<?php

include_once 'app/helpers/db.helper.php';

class CommentModel {
    
    private $dbHelper;
    private $db;

    function __construct() {
        $this->dbHelper = new DbHelper();
        $this->db = $this->dbHelper->connect();
    }

    // Obtiene un comentario
    function get($id) {
        $query = $this->db->prepare('   SELECT * FROM comment WHERE id = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);;
    }

    // Obtiene todos los comentarios
    function getAll() {
        $query = $this->db->prepare('   SELECT * FROM comment');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // Obtiene todos los comentarios de una mascota
    function getFromPet($idPet){
        $query = $this->db->prepare('   SELECT com.id, com.message, com.rate, usr.name 
                                        FROM comment AS com   
                                        INNER JOIN `user` as `usr` ON `com`.`user_id` = `usr`.`id` 
                                        WHERE pet_id = ?');
        $query->execute([$idPet]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // Agrega un comentario a la DB
    function add($userId, $petId, $message, $rate) {
        $query = $this->db->prepare('   INSERT INTO comment (`user_id`, `pet_id`, `message`, `rate`) 
                                        VALUES (?,?,?,?)');
        $query->execute([$userId, $petId, $message, $rate]);
        // Obtengo y devuelvo el ID del comentario nuevo
        return $this->db->lastInsertId();
    }

    // Elimina un comentario
    function remove($id) {  
        $query = $this->db->prepare('   DELETE FROM comment WHERE id = ?');
        $query->execute([$id]);
        // Obtengo cuantas filas cambiaron para saber si no hubo error
        return $query->rowCount();
    }
}
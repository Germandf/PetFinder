<?php

include_once 'app/helpers/db.helper.php';

class UserModel {

    private $db;
    private $dbHelper;

    function __construct() {
        $this->dbHelper = new DbHelper();
        $this->db = $this->dbHelper->connect();
    }

    // Devuelve un usuario dado un email.
    public function getByEmail($email) {
        $query = $this->db->prepare('SELECT * FROM user WHERE email = ?');
        $query->execute([$email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    // Devuelve un usuario dado un email.
    public function getById($id) {
        $query = $this->db->prepare('SELECT * FROM user WHERE id = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function setUserPermission($userId, $permissionId){
        $query = $this->db->prepare('UPDATE `user` SET `permission_id` = ? WHERE `user`.`id` = ?');
        return $query->execute([$permissionId,$userId]);
    }

    public function add($email, $password, $name, $surname){
        $query = $this->db->prepare('   INSERT INTO `user` (`name`, `surname`, `email`, `password`, `permission_id`)
                                        VALUES (?, ?, ?, ?, ?);');        
        if($query->execute([$name, $surname, $email, $password, USER_PERMISSION]) == 1){
            //Si se guardo el usuario correctamente
            return true;
        }
        return false;
    }
}
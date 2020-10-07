<?php

include_once 'app/helpers/config.php';

class UserModel {
    
    private $db;

    function __construct() {
        $this->db = $this->connect();
    }

    // Abre conexión a la base de datos
    private function connect() {
        $db = new PDO('mysql:host='.DB_HOST.';'.'dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
        return $db;
    }

    // Devuelve un usuario dado un email.
    public function getByEmail($email) {
        $query = $this->db->prepare('SELECT * FROM user WHERE email = ?');
        $query->execute([$email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
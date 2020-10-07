<?php

class UserModel {
    
    private $db;

    function __construct() {
        $this->db = $this->connect();
    }

    // Abre conexión a la base de datos
    private function connect() {
        $db = new PDO('mysql:host=localhost;'.'dbname=petfinder;charset=utf8', 'root', '');     //¡¡CORREGIR!!
        return $db;
    }

    // Devuelve un usuario dado un email.
    public function getByEmail($email) {
        $query = $this->db->prepare('SELECT * FROM users WHERE email = ?');                     //¡¡CORREGIR!!
        $query->execute([$email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
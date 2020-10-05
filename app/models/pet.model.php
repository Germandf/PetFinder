<?php

class PetModel {

    private $db;

    function __construct() {
        // Abro la conexión
        $this->db = $this->connect();
    }

    //Abre conexión a la base de datos;
    private function connect() {
        $db = new PDO('mysql:host=localhost;'.'dbname=db_todolist;charset=utf8', 'root', '');
        return $db;
    }

    //Devuelve todas las tareas de la base de datos.
    function getAll() {

        // Enviar la consulta (2 sub-pasos: prepare y execute)
        $query = $this->db->prepare('SELECT * FROM pets');
        $query->execute();

        // Obtengo la respuesta con un fetchAll (porque son muchos)
        $pets = $query->fetchAll(PDO::FETCH_OBJ); // arreglo de tareas

        return $pets;
    }
}
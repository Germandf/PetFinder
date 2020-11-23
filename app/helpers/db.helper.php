<?php 
    include_once 'app/config.php';
  
    class DbHelper {    
        // Abre conexión a la base de datos
        public function connect() {
            $db = new PDO('mysql:host='.DB_HOST.';'.'dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
            if(DEBUG_MODE) { //Si estamos debugeando mostramos los errores
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //Remove
            }
            return $db;
        }
    }
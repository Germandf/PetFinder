<?php
    class FileController{
        function generateFileName($length = 12){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        function uploadImage($inputName){
            //Donde vamos a guardar la imagen
            $targetDir = "images/pets/";

            //Obtengo el nombre que tiene el archivo actual
            $targetFile = basename($_FILES[$inputName]["name"]);

            //Obtengo la extensión de la imagen que voy a subir
            $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));


            // Permito ciertos tipos de archivos
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                return false;
            }

            $newFileName = $targetDir.$this->generateFileName(10).'.'.$imageFileType;
            if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $newFileName)) {
                return $newFileName;
            } else {
                return false;
            }
    
        }
    }
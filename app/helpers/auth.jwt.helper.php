<?php
require_once('vendor/autoload.php');
require_once('app/config.php');

use Firebase\JWT\JWT;

class AuthJwtHelper
{
    private $encrypt; 

    function __construct() {
        $this->encrypt = ['HS256'];
    }

    public function getUser(){
        $bearer = $this->getBearerToken();
        if($bearer == null){
            return false;
        }
        $data = $this->GetData($bearer);
        if($data){
            return json_decode($data);
        }
        return false;
    }

    public function isAdmin(){
        $user = $this->getUser();
        if(!empty($user)){
            return $user->permission == 1;
        }
        return false;
    }
    
    public function isAuth()
    {
        $bearer = $this->getBearerToken();
        if($bearer == null){
            return false;
        }
        if($this->GetData($bearer)){
            return true;
        }
        return false;
    }

    public  function Login($data)
    {
        $time = time();
        $token = array(
            'exp' => $time + EXP_TIME,
            'data' => $data
        );
        return JWT::encode($token, SECRET_KEY);
    }
    
    function getAuthorizationHeader()
    {   
        //De aca sacamos el parametro Authorization, que tiene un bearer con el JWT
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $arrayKeys = array_keys($requestHeaders);
            $arrayValues = array_values($requestHeaders);
            $requestHeaders = array_combine($arrayKeys,  $arrayValues );
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            //Sacamos el bearer y devolvemos el JWT
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                //Devolvemos el JWT solo, sin el bearer
                return $matches[1];
            }
        }
        return null;
    }

    public function GetData($token)
    {
        try {
            return JWT::decode(
                $token,
                SECRET_KEY,
                $this->encrypt
            )->data;
        } catch (Exception $e) {
            return false;
        }
    }
}

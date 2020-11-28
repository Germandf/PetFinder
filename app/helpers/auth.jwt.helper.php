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
        if($this->GetData($bearer)){
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
            'exp' => $time + (60 * 60 * 24 * 15), //Expira en 15 días
            'data' => $data
        );

        return JWT::encode($token, SECRET_KEY);
    }
    
    function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
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
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
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

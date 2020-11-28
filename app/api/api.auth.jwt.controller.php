<?php
require_once 'app/models/user.model.php';
require_once 'app/api/api.view.php';
include_once 'app/helpers/auth.jwt.helper.php';

class AuthJwtController
{

    private $view;
    private $userModel;
    private $authJwtHelper;
    private $data;

    function __construct()
    {
        $this->data = file_get_contents("php://input");
        $this->view = new APIView();
        $this->userModel = new UserModel();
        $this->authJwtHelper = new AuthJwtHelper();
    }
    
   
    
    public function signIn()
    {
        $body = $this->getData();
        if (empty($body)) {
            return $this->view->response("Faltan datos obligatorios", 400);
        }
        $email = isset($body->email) ? $body->email : null;
        $password = isset($body->password) ? $body->password : null;

        if (empty($email) || empty($password)) {
            return $this->view->response("Faltan datos obligatorios", 400);
        }

        // Obtengo el usuario
        $user = $this->userModel->getByEmail($email);
        // Si el usuario no existe le informo que el mail es incorrecto
        if (!$user) {
            return $this->view->response("No existe ningun usuario para ese Email", 401);
        }
        // Si la contraseña es correcta
        if (password_verify($password, $user->password)) {
            //Obtengo el JWT y lo devuelvo
            $token = $this->authJwtHelper->Login(json_encode(["id" => $user->id, "name" => $user->name, "permission" => $user->permission_id]));

            return $this->view->response(["token" => $token], 200);
        }
    }
    // Lee la variable asociada a la entrada estandar y la convierte en JSON
    function getData()
    {
        return json_decode($this->data);
    }

    public function show404($params = null)
    {
        $this->view->response("El recurso solicitado no existe", 404);
    }
}

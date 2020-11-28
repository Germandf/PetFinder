<?php
require_once 'app/models/comment.model.php';
require_once 'app/api/api.view.php';
include_once 'app/helpers/auth.helper.php';
include_once 'app/helpers/auth.jwt.helper.php';

class ApiCommentController {

    private $model;
    private $view;
    private $authHelper;
    private $authJwtHelper;

    function __construct() {
        $this->model = new CommentModel();
        $this->view = new APIView();
        $this->authHelper = new AuthHelper();
        $this->data = file_get_contents("php://input");
        $this->authJwtHelper = new AuthJwtHelper();

    }

    // Lee la variable asociada a la entrada estandar y la convierte en JSON
    function getData(){ 
        return json_decode($this->data); 
    }

    public function getFromPet($params = null){
        //Con esta función obtenemos todos los comentarios de una mascota
        $idPet = $params[':ID'];
        $comments = $this->model->getFromPet($idPet);
        if($comments){
            $this->view->response($comments, 200);
        }
    }
    public function add() {
        $body = $this->getData();
        if(empty($body)){
            return $this->view->response("Faltan datos obligatorios", 400);
        }
        $userId = $this->authHelper->getUserId();

        if(empty($userId) ){
            //No estamos mediante TOKEN
            $userId = $this->authJwtHelper->getUser()->id;
        }
        $petId = isset($body->petId) ? $body->petId : null;
        $message = isset($body->message) ? $body->message : null;
        $rate = isset($body->rate) ? $body->rate : null;
        if($this->authHelper->isAuth() || $this->authJwtHelper->isAuth()){
            if (empty($petId) || empty($message) || empty($rate)) {
                $this->view->response("Faltan datos obligatorios", 400);
            }
            else{
                $id = $this->model->add($userId, $petId, $message, $rate);
                if ($id > 0) {
                    $comment = $this->model->get($id);
                    $this->view->response($comment, 200);
                }
                else {
                    $this->view->response("No se pudo insertar", 500);
                }
            }
        }
        else{
            $this->view->response("Acceso denegado", 403);
        }
    }

    public function getAll() {
        $comments = $this->model->getAll();
        $this->view->response($comments, 200);
    }

    public function delete($params = null) {
        $idComment = $params[':ID'];
        $success = $this->model->remove($idComment);
        
    
        if($this->authHelper->isAdmin() ||  $this->authJwtHelper->isAdmin()){
            if ($success) {
                $this->view->response("La tarea con el id=$idComment se borró exitosamente", 200);
            }
            else { 
                $this->view->response("La tarea con el id=$idComment no existe", 404);
            }
        }else{
            $this->view->response("Acceso denegado", 403);
        }
    }

    public function show404($params = null) {
        $this->view->response("El recurso solicitado no existe", 404);
    }

}
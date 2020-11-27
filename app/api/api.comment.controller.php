<?php
require_once 'app/models/comment.model.php';
require_once 'app/api/api.view.php';
include_once 'app/helpers/auth.helper.php';

class ApiCommentController {

    private $model;
    private $view;
    private $authHelper;

    function __construct() {
        $this->model = new CommentModel();
        $this->view = new APIView();
        $this->authHelper = new AuthHelper();
        $this->data = file_get_contents("php://input");
    }

    // Lee la variable asociada a la entrada estandar y la convierte en JSON
    function getData(){ 
        return json_decode($this->data); 
    }

    // Obtiene un comentario
    public function get($params = null) {
        $idComment = $params[':ID'];
        $comment = $this->model->get($idComment);
        if ($comment) {
            $this->view->response($comment, 200);
        }
        else{
            $this->view->response("El comentario con el id $idComment no existe", 404);
        }
    }

    // Obtiene todos los comentarios
    public function getAll() {
        $comments = $this->model->getAll();
        if($comments){
            $this->view->response($comments, 200);
        }
        else{
            $this->view->response("No se encontraron comentarios", 404);
        }
    }

    // Obtiene todos los comentarios de una mascota
    public function getFromPet($params = null){
        $idPet = $params[':ID'];
        $comments = $this->model->getFromPet($idPet);
        if($comments){
            $this->view->response($comments, 200);
        }
        else{
            $this->view->response("La mascota con id $idPet no tiene comentarios o bien no existe", 404);
        }
    }

    // Agrega un comentario
    public function add() {
        $body = $this->getData();
        if(empty($body)){
            return $this->view->response("Faltan datos obligatorios", 400);
        }
        $userId = $this->authHelper->getUserId();
        $petId = $body->petId;
        $message = $body->message;
        $rate = $body->rate;
        if($this->authHelper->isAuth()){
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

    // Borra un comentario
    public function delete($params = null) {
        $idComment = $params[':ID'];
        $success = $this->model->remove($idComment);
        if($this->authHelper->isAdmin()){
            if ($success) {
                $this->view->response("El comentario con el id $idComment se borró exitosamente", 200);
            }
            else { 
                $this->view->response("El comentario con el id $idComment no existe", 404);
            }
        }else{
            $this->view->response("Acceso denegado", 403);
        }
    }

    // Muestra error 404
    public function show404($params = null) {
        $this->view->response("El recurso solicitado no existe", 404);
    }

}
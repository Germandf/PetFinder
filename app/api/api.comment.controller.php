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

    public function add() {
        $body = $this->getData();
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

    public function getAll() {
        $comments = $this->model->getAll();
        $this->view->response($comments, 200);
    }

    public function delete($params = null) {
        $idComment = $params[':ID'];
        $success = $this->model->remove($idComment);
        if ($success) {
            $this->view->response("La tarea con el id=$idComment se borró exitosamente", 200);
        }
        else { 
            $this->view->response("La tarea con el id=$idComment no existe", 404);
        }
    }

    public function show404($params = null) {
        $this->view->response("El recurso solicitado no existe", 404);
    }

}
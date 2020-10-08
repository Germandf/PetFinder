<?php

include_once 'app/views/auth.view.php';

class AuthController {
    function __construct() {
        $this->view = new AuthView();
    }
    function showLoginForm() {
        $this->view->showLoginForm();
    }
}
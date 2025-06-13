<?php
// Base Controller class for the National Centralised Patient Portal

class Controller {
    // Load model
    public function model($model) {
        // Require model file
        require_once 'models/' . $model . '.php';
        // Instantiate model
        return new $model();
    }

    // Load view
    public function view($view, $data = []) {
        // Check if view file exists
        if(file_exists('views/' . $view . '.php')) {
            // Require view file
            require_once 'views/' . $view . '.php';
        } else {
            // View does not exist
            die('View does not exist');
        }
    }

    // Redirect to another page
    public function redirect($url) {
        header('Location: ' . APP_URL . '/' . $url);
    }
}
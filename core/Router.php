<?php
// Router class for the National Centralised Patient Portal

class Router {
    protected $controller = DEFAULT_CONTROLLER;
    protected $method = DEFAULT_METHOD;
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Check if controller exists
        if(isset($url[0]) && file_exists('controllers/' . ucwords($url[0]) . 'Controller.php')) {
            $this->controller = ucwords($url[0]);
            unset($url[0]);
        }

        // Include the controller
        require_once 'controllers/' . $this->controller . 'Controller.php';

        // Instantiate controller
        $this->controller = new $this->controller();

        // Check if method exists
        if(isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Get parameters
        $this->params = $url ? array_values($url) : [];
    }

    public function route() {
        // Call the controller method with parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function parseUrl() {
        if(isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
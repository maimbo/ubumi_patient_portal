<?php
// Main entry point for the National Centralised Patient Portal
// Following MVC pattern

// Initialize session
session_start();

// Include configuration
require_once 'config/config.php';

// Include router
require_once 'core/Router.php';

// Route the request
$router = new Router();
$router->route();
<?php
// Configuration file for the National Centralised Patient Portal

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'patient_portal');

// Application configuration
define('APP_NAME', 'National Centralised Patient Portal');
define('APP_URL', 'http://localhost/patient-portal');
define('APP_ROOT', dirname(dirname(__FILE__)));

// Default controller and method
define('DEFAULT_CONTROLLER', 'Dashboard');
define('DEFAULT_METHOD', 'index');

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
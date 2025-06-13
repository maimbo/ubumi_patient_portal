<?php
// Base Model class for the National Centralised Patient Portal

class Model {
    protected $db;

    public function __construct() {
        // Create database connection
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Check connection
        if($this->db->connect_error) {
            die('Database connection failed: ' . $this->db->connect_error);
        }
    }

    // Execute query
    public function query($sql, $params = []) {
        if(empty($params)) {
            return $this->db->query($sql);
        }

        $stmt = $this->db->prepare($sql);

        if(!$stmt) {
            die('Query preparation failed: ' . $this->db->error);
        }

        // Bind parameters
        $types = '';
        foreach($params as $param) {
            if(is_int($param)) {
                $types .= 'i';
            } elseif(is_float($param)) {
                $types .= 'd';
            } elseif(is_string($param)) {
                $types .= 's';
            } else {
                $types .= 'b';
            }
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt;
    }

    // Get single record
    public function getSingle($sql, $params = []) {
        $result = $this->query($sql, $params);
        
        if($result instanceof mysqli_stmt) {
            $result = $result->get_result();
        }

        return $result->fetch_assoc();
    }

    // Get multiple records
    public function getMultiple($sql, $params = []) {
        $result = $this->query($sql, $params);
        
        if($result instanceof mysqli_stmt) {
            $result = $result->get_result();
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
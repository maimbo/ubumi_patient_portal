<?php

class DataController {
    private $dataPath;

    public function __construct() {
        $this->dataPath = dirname(__DIR__) . '/data/';
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : null;

        if (!$endpoint) {
            $this->sendResponse(['error' => 'Endpoint not specified'], 400);
            return;
        }

        switch ($method) {
            case 'GET':
                $this->handleGet($endpoint);
                break;
            case 'POST':
                $this->handlePost($endpoint);
                break;
            case 'PUT':
                $this->handlePut($endpoint);
                break;
            case 'DELETE':
                $this->handleDelete($endpoint);
                break;
            default:
                $this->sendResponse(['error' => 'Method not allowed'], 405);
        }
    }

    private function handleGet($endpoint) {
        $filePath = $this->dataPath . $endpoint . '.json';
        if (!file_exists($filePath)) {
            $this->sendResponse(['error' => 'Resource not found'], 404);
            return;
        }

        $data = file_get_contents($filePath);
        $this->sendResponse(json_decode($data), 200);
    }

    private function handlePost($endpoint) {
        $filePath = $this->dataPath . $endpoint . '.json';
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            $this->sendResponse(['error' => 'Invalid input'], 400);
            return;
        }

        if (file_exists($filePath)) {
            $data = json_decode(file_get_contents($filePath), true);
            if (isset($data['records'])) {
                $data['records'][] = $input;
            } else {
                // Handle different data structures based on endpoint
                switch ($endpoint) {
                    case 'appointments':
                        $data['upcomingAppointments'][] = $input;
                        break;
                    case 'messages':
                        $data['inbox'][] = $input;
                        break;
                    default:
                        // Generic handling
                        if (!isset($data['items'])) $data['items'] = [];
                        $data['items'][] = $input;
                }
            }
            file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
            $this->sendResponse($data, 201);
        } else {
            $this->sendResponse(['error' => 'Resource not found'], 404);
        }
    }

    private function handlePut($endpoint) {
        $filePath = $this->dataPath . $endpoint . '.json';
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            $this->sendResponse(['error' => 'Invalid input'], 400);
            return;
        }

        if (file_exists($filePath)) {
            file_put_contents($filePath, json_encode($input, JSON_PRETTY_PRINT));
            $this->sendResponse($input, 200);
        } else {
            $this->sendResponse(['error' => 'Resource not found'], 404);
        }
    }

    private function handleDelete($endpoint) {
        $filePath = $this->dataPath . $endpoint . '.json';
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if (!$id) {
            $this->sendResponse(['error' => 'ID not specified'], 400);
            return;
        }

        if (file_exists($filePath)) {
            $data = json_decode(file_get_contents($filePath), true);
            
            // Handle different data structures based on endpoint
            if (isset($data['records'])) {
                $data['records'] = array_filter($data['records'], function($item) use ($id) {
                    return $item['id'] !== $id;
                });
            } else {
                switch ($endpoint) {
                    case 'appointments':
                        $data['upcomingAppointments'] = array_filter($data['upcomingAppointments'], 
                            function($item) use ($id) { return $item['id'] !== $id; });
                        break;
                    case 'messages':
                        $data['inbox'] = array_filter($data['inbox'], 
                            function($item) use ($id) { return $item['id'] !== $id; });
                        break;
                    default:
                        if (isset($data['items'])) {
                            $data['items'] = array_filter($data['items'], 
                                function($item) use ($id) { return $item['id'] !== $id; });
                        }
                }
            }
            
            file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
            $this->sendResponse(['success' => true], 200);
        } else {
            $this->sendResponse(['error' => 'Resource not found'], 404);
        }
    }

    private function sendResponse($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
    }
}

// Initialize and handle the request
$controller = new DataController();
$controller->handleRequest();
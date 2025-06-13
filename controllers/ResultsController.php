<?php
// Results Controller for the National Centralised Patient Portal

require_once 'core/Controller.php';

class Results extends Controller {
    private $resultModel;

    public function __construct() {
        // Load model
        $this->resultModel = $this->model('ResultModel');
    }

    // Results index page
    public function index() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get results
        $results = $this->resultModel->getUserResults($_SESSION['user_id']);

        // Load view with data
        $data = [
            'results' => $results
        ];

        $this->view('results/index', $data);
    }

    // View result details
    public function view($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get result
        $result = $this->resultModel->getResultById($id);

        // Check if result belongs to user
        if($result['user_id'] != $_SESSION['user_id']) {
            $this->redirect('results');
        }

        // Get result details
        $details = $this->resultModel->getResultDetails($id);

        // Load view with data
        $data = [
            'result' => $result,
            'details' => $details
        ];

        $this->view('results/view', $data);
    }

    // Download result
    public function download($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get result
        $result = $this->resultModel->getResultById($id);

        // Check if result belongs to user
        if($result['user_id'] != $_SESSION['user_id']) {
            $this->redirect('results');
        }

        // Get result file
        $file = $this->resultModel->getResultFile($id);

        // Check if file exists
        if(!$file) {
            die('File not found');
        }

        // Set headers
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $result['name'] . '.pdf"');

        // Output file
        echo $file;
        exit;
    }

    // Share result
    public function share($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get result
        $result = $this->resultModel->getResultById($id);

        // Check if result belongs to user
        if($result['user_id'] != $_SESSION['user_id']) {
            $this->redirect('results');
        }

        // Check if form is submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'email' => trim($_POST['email']),
                'result' => $result,
                'email_err' => ''
            ];

            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Invalid email format';
            }

            // Make sure errors are empty
            if(empty($data['email_err'])) {
                // Validated
                // Share result
                if($this->resultModel->shareResult($id, $data['email'])) {
                    // Result shared
                    // Redirect to results
                    $this->redirect('results');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('results/share', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'result' => $result,
                'email_err' => ''
            ];

            // Load view
            $this->view('results/share', $data);
        }
    }
}
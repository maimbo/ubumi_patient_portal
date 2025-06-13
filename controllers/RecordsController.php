<?php
// Health Records Controller for the National Centralised Patient Portal

require_once 'core/Controller.php';

class Records extends Controller {
    private $recordModel;

    public function __construct() {
        // Load model
        $this->recordModel = $this->model('RecordModel');
    }

    // Health records index page
    public function index() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get records
        $records = $this->recordModel->getUserRecords($_SESSION['user_id']);

        // Load view with data
        $data = [
            'records' => $records
        ];

        $this->view('records/index', $data);
    }

    // View record details
    public function view($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get record
        $record = $this->recordModel->getRecordById($id);

        // Check if record belongs to user
        if($record['user_id'] != $_SESSION['user_id']) {
            $this->redirect('records');
        }

        // Load view with data
        $data = [
            'record' => $record
        ];

        $this->view('records/view', $data);
    }

    // View medical history
    public function history() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get medical history
        $history = $this->recordModel->getUserMedicalHistory($_SESSION['user_id']);

        // Load view with data
        $data = [
            'history' => $history
        ];

        $this->view('records/history', $data);
    }

    // View allergies
    public function allergies() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get allergies
        $allergies = $this->recordModel->getUserAllergies($_SESSION['user_id']);

        // Load view with data
        $data = [
            'allergies' => $allergies
        ];

        $this->view('records/allergies', $data);
    }

    // View immunizations
    public function immunizations() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get immunizations
        $immunizations = $this->recordModel->getUserImmunizations($_SESSION['user_id']);

        // Load view with data
        $data = [
            'immunizations' => $immunizations
        ];

        $this->view('records/immunizations', $data);
    }

    // View conditions
    public function conditions() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get conditions
        $conditions = $this->recordModel->getUserConditions($_SESSION['user_id']);

        // Load view with data
        $data = [
            'conditions' => $conditions
        ];

        $this->view('records/conditions', $data);
    }

    // View procedures
    public function procedures() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get procedures
        $procedures = $this->recordModel->getUserProcedures($_SESSION['user_id']);

        // Load view with data
        $data = [
            'procedures' => $procedures
        ];

        $this->view('records/procedures', $data);
    }

    // Upload document
    public function upload() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Check if form is submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'title_err' => '',
                'description_err' => '',
                'file_err' => ''
            ];

            // Validate title
            if(empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            // Validate description
            if(empty($data['description'])) {
                $data['description_err'] = 'Please enter description';
            }

            // Validate file
            if(empty($_FILES['document']['name'])) {
                $data['file_err'] = 'Please select a file';
            } else {
                // Get file extension
                $fileExt = strtolower(pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION));

                // Check if file is allowed
                $allowed = ['pdf', 'jpg', 'jpeg', 'png'];

                if(!in_array($fileExt, $allowed)) {
                    $data['file_err'] = 'File type not allowed';
                }
            }

            // Make sure errors are empty
            if(empty($data['title_err']) && empty($data['description_err']) && empty($data['file_err'])) {
                // Validated
                // Upload file
                $fileName = uniqid() . '.' . $fileExt;
                $fileTmpName = $_FILES['document']['tmp_name'];
                $fileDestination = 'uploads/' . $fileName;

                if(move_uploaded_file($fileTmpName, $fileDestination)) {
                    // File uploaded
                    // Add document to database
                    if($this->recordModel->uploadDocument($_SESSION['user_id'], $data['title'], $data['description'], $fileName)) {
                        // Document added
                        // Redirect to records
                        $this->redirect('records');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('records/upload', $data);
            }
        } else {
            // Init data
            $data = [
                'title' => '',
                'description' => '',
                'title_err' => '',
                'description_err' => '',
                'file_err' => ''
            ];

            // Load view
            $this->view('records/upload', $data);
        }
    }
}
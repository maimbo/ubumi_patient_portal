<?php
// Medications Controller for the National Centralised Patient Portal

require_once 'core/Controller.php';

class Medications extends Controller {
    private $medicationModel;

    public function __construct() {
        // Load model
        $this->medicationModel = $this->model('MedicationModel');
    }

    // Medications index page
    public function index() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get medications
        $medications = $this->medicationModel->getUserMedications($_SESSION['user_id']);

        // Load view with data
        $data = [
            'medications' => $medications
        ];

        $this->view('medications/index', $data);
    }

    // View medication details
    public function view($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get medication
        $medication = $this->medicationModel->getMedicationById($id);

        // Check if medication belongs to user
        if($medication['user_id'] != $_SESSION['user_id']) {
            $this->redirect('medications');
        }

        // Load view with data
        $data = [
            'medication' => $medication
        ];

        $this->view('medications/view', $data);
    }

    // Request medication renewal
    public function renew($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get medication
        $medication = $this->medicationModel->getMedicationById($id);

        // Check if medication belongs to user
        if($medication['user_id'] != $_SESSION['user_id']) {
            $this->redirect('medications');
        }

        // Check if form is submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'notes' => trim($_POST['notes']),
                'medication' => $medication,
                'notes_err' => ''
            ];

            // Validate notes
            if(empty($data['notes'])) {
                $data['notes_err'] = 'Please enter notes';
            }

            // Make sure errors are empty
            if(empty($data['notes_err'])) {
                // Validated
                // Request renewal
                if($this->medicationModel->requestRenewal($id, $data['notes'])) {
                    // Renewal requested
                    // Redirect to medications
                    $this->redirect('medications');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('medications/renew', $data);
            }
        } else {
            // Init data
            $data = [
                'notes' => '',
                'medication' => $medication,
                'notes_err' => ''
            ];

            // Load view
            $this->view('medications/renew', $data);
        }
    }

    // Set medication reminder
    public function reminder($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get medication
        $medication = $this->medicationModel->getMedicationById($id);

        // Check if medication belongs to user
        if($medication['user_id'] != $_SESSION['user_id']) {
            $this->redirect('medications');
        }

        // Check if form is submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'time' => trim($_POST['time']),
                'frequency' => trim($_POST['frequency']),
                'medication' => $medication,
                'time_err' => '',
                'frequency_err' => ''
            ];

            // Validate time
            if(empty($data['time'])) {
                $data['time_err'] = 'Please enter time';
            }

            // Validate frequency
            if(empty($data['frequency'])) {
                $data['frequency_err'] = 'Please select frequency';
            }

            // Make sure errors are empty
            if(empty($data['time_err']) && empty($data['frequency_err'])) {
                // Validated
                // Set reminder
                if($this->medicationModel->setReminder($id, $data['time'], $data['frequency'])) {
                    // Reminder set
                    // Redirect to medications
                    $this->redirect('medications');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('medications/reminder', $data);
            }
        } else {
            // Init data
            $data = [
                'time' => '',
                'frequency' => '',
                'medication' => $medication,
                'time_err' => '',
                'frequency_err' => ''
            ];

            // Load view
            $this->view('medications/reminder', $data);
        }
    }
}
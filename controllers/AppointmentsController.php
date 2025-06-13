<?php
// Appointments Controller for the National Centralised Patient Portal

require_once 'core/Controller.php';

class Appointments extends Controller {
    private $appointmentModel;
    private $providerModel;

    public function __construct() {
        // Load models
        $this->appointmentModel = $this->model('AppointmentModel');
        $this->providerModel = $this->model('ProviderModel');
    }

    // Appointments index page
    public function index() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get appointments
        $appointments = $this->appointmentModel->getUserAppointments($_SESSION['user_id']);

        // Load view with data
        $data = [
            'appointments' => $appointments
        ];

        $this->view('appointments/index', $data);
    }

    // View appointment details
    public function view($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get appointment
        $appointment = $this->appointmentModel->getAppointmentById($id);

        // Check if appointment belongs to user
        if($appointment['user_id'] != $_SESSION['user_id']) {
            $this->redirect('appointments');
        }

        // Get provider
        $provider = $this->providerModel->getProviderById($appointment['provider_id']);

        // Load view with data
        $data = [
            'appointment' => $appointment,
            'provider' => $provider
        ];

        $this->view('appointments/view', $data);
    }

    // Book appointment page
    public function book() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get providers
        $providers = $this->providerModel->getProviders();

        // Check if form is submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'provider_id' => trim($_POST['provider_id']),
                'date' => trim($_POST['date']),
                'time' => trim($_POST['time']),
                'reason' => trim($_POST['reason']),
                'providers' => $providers,
                'provider_id_err' => '',
                'date_err' => '',
                'time_err' => '',
                'reason_err' => ''
            ];

            // Validate provider
            if(empty($data['provider_id'])) {
                $data['provider_id_err'] = 'Please select a provider';
            }

            // Validate date
            if(empty($data['date'])) {
                $data['date_err'] = 'Please select a date';
            }

            // Validate time
            if(empty($data['time'])) {
                $data['time_err'] = 'Please select a time';
            }

            // Validate reason
            if(empty($data['reason'])) {
                $data['reason_err'] = 'Please enter a reason';
            }

            // Make sure errors are empty
            if(empty($data['provider_id_err']) && empty($data['date_err']) && empty($data['time_err']) && empty($data['reason_err'])) {
                // Validated
                // Book appointment
                if($this->appointmentModel->bookAppointment($_SESSION['user_id'], $data['provider_id'], $data['date'], $data['time'], $data['reason'])) {
                    // Appointment booked
                    // Redirect to appointments
                    $this->redirect('appointments');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('appointments/book', $data);
            }
        } else {
            // Init data
            $data = [
                'provider_id' => '',
                'date' => '',
                'time' => '',
                'reason' => '',
                'providers' => $providers,
                'provider_id_err' => '',
                'date_err' => '',
                'time_err' => '',
                'reason_err' => ''
            ];

            // Load view
            $this->view('appointments/book', $data);
        }
    }

    // Cancel appointment
    public function cancel($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get appointment
        $appointment = $this->appointmentModel->getAppointmentById($id);

        // Check if appointment belongs to user
        if($appointment['user_id'] != $_SESSION['user_id']) {
            $this->redirect('appointments');
        }

        // Cancel appointment
        if($this->appointmentModel->cancelAppointment($id)) {
            // Appointment cancelled
            // Redirect to appointments
            $this->redirect('appointments');
        } else {
            die('Something went wrong');
        }
    }
}
<?php
// Dashboard Controller for the National Centralised Patient Portal

require_once 'core/Controller.php';

class Dashboard extends Controller {
    private $userModel;
    private $appointmentModel;
    private $medicationModel;
    private $messageModel;
    private $resultModel;

    public function __construct() {
        // Load models
        $this->userModel = $this->model('UserModel');
        $this->appointmentModel = $this->model('AppointmentModel');
        $this->medicationModel = $this->model('MedicationModel');
        $this->messageModel = $this->model('MessageModel');
        $this->resultModel = $this->model('ResultModel');
    }

    // Dashboard index page
    public function index() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get user data
        $user = $this->userModel->getUserById($_SESSION['user_id']);

        // Get upcoming appointments
        $appointments = $this->appointmentModel->getUpcomingAppointments($_SESSION['user_id']);

        // Get medications
        $medications = $this->medicationModel->getUserMedications($_SESSION['user_id']);

        // Get recent messages
        $messages = $this->messageModel->getRecentMessages($_SESSION['user_id']);

        // Get recent test results
        $results = $this->resultModel->getRecentResults($_SESSION['user_id']);

        // Get health alerts
        $alerts = $this->userModel->getUserAlerts($_SESSION['user_id']);

        // Load view with data
        $data = [
            'user' => $user,
            'appointments' => $appointments,
            'medications' => $medications,
            'messages' => $messages,
            'results' => $results,
            'alerts' => $alerts
        ];

        $this->view('dashboard/index', $data);
    }
}
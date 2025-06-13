<?php
// Messages Controller for the National Centralised Patient Portal

require_once 'core/Controller.php';

class Messages extends Controller {
    private $messageModel;
    private $providerModel;

    public function __construct() {
        // Load models
        $this->messageModel = $this->model('MessageModel');
        $this->providerModel = $this->model('ProviderModel');
    }

    // Messages index page
    public function index() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get messages
        $messages = $this->messageModel->getUserMessages($_SESSION['user_id']);

        // Load view with data
        $data = [
            'messages' => $messages
        ];

        $this->view('messages/index', $data);
    }

    // View message thread
    public function view($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get message thread
        $thread = $this->messageModel->getMessageThread($id);

        // Check if thread belongs to user
        if($thread[0]['user_id'] != $_SESSION['user_id']) {
            $this->redirect('messages');
        }

        // Get provider
        $provider = $this->providerModel->getProviderById($thread[0]['provider_id']);

        // Load view with data
        $data = [
            'thread' => $thread,
            'provider' => $provider
        ];

        $this->view('messages/view', $data);
    }

    // Compose new message
    public function compose() {
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
                'subject' => trim($_POST['subject']),
                'message' => trim($_POST['message']),
                'providers' => $providers,
                'provider_id_err' => '',
                'subject_err' => '',
                'message_err' => ''
            ];

            // Validate provider
            if(empty($data['provider_id'])) {
                $data['provider_id_err'] = 'Please select a provider';
            }

            // Validate subject
            if(empty($data['subject'])) {
                $data['subject_err'] = 'Please enter a subject';
            }

            // Validate message
            if(empty($data['message'])) {
                $data['message_err'] = 'Please enter a message';
            }

            // Make sure errors are empty
            if(empty($data['provider_id_err']) && empty($data['subject_err']) && empty($data['message_err'])) {
                // Validated
                // Send message
                if($this->messageModel->sendMessage($_SESSION['user_id'], $data['provider_id'], $data['subject'], $data['message'])) {
                    // Message sent
                    // Redirect to messages
                    $this->redirect('messages');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('messages/compose', $data);
            }
        } else {
            // Init data
            $data = [
                'provider_id' => '',
                'subject' => '',
                'message' => '',
                'providers' => $providers,
                'provider_id_err' => '',
                'subject_err' => '',
                'message_err' => ''
            ];

            // Load view
            $this->view('messages/compose', $data);
        }
    }

    // Reply to message
    public function reply($id) {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('users/login');
        }

        // Get message thread
        $thread = $this->messageModel->getMessageThread($id);

        // Check if thread belongs to user
        if($thread[0]['user_id'] != $_SESSION['user_id']) {
            $this->redirect('messages');
        }

        // Get provider
        $provider = $this->providerModel->getProviderById($thread[0]['provider_id']);

        // Check if form is submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'message' => trim($_POST['message']),
                'thread' => $thread,
                'provider' => $provider,
                'message_err' => ''
            ];

            // Validate message
            if(empty($data['message'])) {
                $data['message_err'] = 'Please enter a message';
            }

            // Make sure errors are empty
            if(empty($data['message_err'])) {
                // Validated
                // Send reply
                if($this->messageModel->sendReply($id, $_SESSION['user_id'], $thread[0]['provider_id'], $data['message'])) {
                    // Reply sent
                    // Redirect to message thread
                    $this->redirect('messages/view/' . $id);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('messages/reply', $data);
            }
        } else {
            // Init data
            $data = [
                'message' => '',
                'thread' => $thread,
                'provider' => $provider,
                'message_err' => ''
            ];

            // Load view
            $this->view('messages/reply', $data);
        }
    }
}
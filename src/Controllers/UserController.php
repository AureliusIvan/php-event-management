<?php

namespace App\Controllers;

use App\Config\Database;
use App\Middleware\AuthMiddleware;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Exception;

class UserController
{

    public function __construct()
    {
        $authMiddleware = new AuthMiddleware();
    }

    /**
     * @return void
     */
    function loginPage(): void
    {
        $this->render('User/login');
    }

    /**
     * @return void
     */
    public function userLogin(): void
    {
        try {
            // Ensure session is started
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Get the user input
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validate the input
            if (empty($email) || empty($password)) {
                $error = 'All fields are required.';
                $this->render('User/login', ['error' => $error]);
                return;
            }

            // Get the database connection
            $pdo = Database::getInstance()->getConnection();

            // Get the user by email
            $user = User::getByEmail($pdo, $email);

            // Check if the user exists
            if ($user) {
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // create session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = 'admin';

                    header('Location: /');
                    exit;
                } else {
                    $error = 'Invalid email or password.';
                    $this->render('User/login', ['error' => $error]);
                }
            } else {
                $error = 'Invalid email or password.';
                $this->render('User/login', ['error' => $error]);
            }
        } catch (Exception $e) {
            $error = 'An error occurred: ' . $e->getMessage();
            $this->render('User/login', ['error' => $error]);
        }
    }

    /**
     * @return void
     */
    public function createUser(): void
    {
        try {
            // Ensure session is started
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Get the user input
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validate the input
            if (empty($name) || empty($email) || empty($password)) {
                $error = 'All fields are required.';
                $this->render('User/register', ['error' => $error]);
                return;
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare user data
            $userData = [
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
            ];

            // Get the database connection
            $pdo = Database::getInstance()->getConnection();

            // Insert the new user
            $userCreated = User::create($pdo, $userData);

            // Check if the user was created
            $user = User::getByEmail($pdo, $email);


            if ($userCreated && $user) {
                // create session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = 'admin';

                // Redirect to the event list page
                header('Location: / ');
                exit;
            } else {
                $error = 'Error creating user!';
                $this->render('User/register', ['message' => $error]);
            }
        } catch (Exception $e) {
            $error = 'An error occurred: ' . $e->getMessage();
            $this->render('User/register', ['message' => $error]);
        }
    }

    /**
     * @return void
     */
    function register(): void
    {
        $this->render('User/register', ['title' => 'Register']);
    }


    /**
     * Handle the request to the home page.
     */
    public function index(): void
    {
        // Data to pass to the view
        $data = [
            'title' => 'Welcome to My PHP App',
            'message' => 'This is a simple PHP application using a clean folder structure.',
        ];

        // Render the view
        $this->render('home', $data);
    }

    /**
     * Handle the request to the event list page.
     */
    public function eventList(): void
    {
        $pdo = Database::getInstance()->getConnection();
        $events = Event::getAll($pdo);

        $this->render(
            'User/eventList',
            ['events' => $events]
        );
    }

    public function eventDetails($id): void
    {
        $pdo = Database::getInstance()->getConnection();
        $event = Event::getById($pdo, $id);

        // check whether the user is already registered for the event
        $user_id = $_SESSION['user_id'];
        $transaction = Transaction::getByUserIdAndEventId($pdo, $user_id, $id);
        if ($transaction) {
            $event['is_registered'] = true;
        } else {
            $event['is_registered'] = false;
        }
        $this->render('User/eventDetails', [
            'event' => $event
        ]);
    }

    /**
     * Handle the request to the event registration page.
     */
    public function eventRegistration(): void
    {
        $user_id = $_SESSION['user_id'];
        $event_id = $_POST['event_id'];

        try {
            $pdo = Database::getInstance()->getConnection();
            Transaction::create($pdo,
                [
                    'user_id' => $user_id,
                    'event_id' => $event_id,
                    'amount' => 0,
                    'status' => 'success',
                    'created_at' => date('Y-m-d H:i:s')]
            );
            $this->render('User/eventRegisteredList', [
                    'status' => 'success',
                    'message' => 'Event registered successfully.'
                ]
            );
        } catch (Exception $e) {
            $error = 'An error occurred: ' . $e->getMessage();
            echo $error;
        }
    }

    public function eventRegisteredListPage(): void
    {
        $user_transactions = Transaction::getByUserId(Database::getInstance()->getConnection(), $_SESSION['user_id']);
        $events = [];
        foreach ($user_transactions as $transaction) {
            $event = Event::getById(Database::getInstance()->getConnection(), $transaction['event_id']);
            $events[] = $event;
        }
        $this->render(
            'User/eventRegisteredList',
            ['events' => $events]
        );
    }

    /**
     * Handle the request to the event cancellation page.
     */
    public function eventCancellation(): void
    {
        $id = $_POST['event_id'];
        $pdo = Database::getInstance()->getConnection();
        $transaction = Transaction::getByUserIdAndEventId($pdo, $_SESSION['user_id'], $id);
        if ($transaction) {
            Transaction::delete($pdo, $transaction['id']);
            $this->render('User/eventRegisteredList', [
                    'status' => 'success',
                    'message' => 'Event cancelled successfully.'
                ]
            );
        } else {
            $this->render('User/eventRegisteredList', [
                    'status' => 'error',
                    'message' => 'Event not found.'
                ]
            );
        }
    }

    /**
     * Handle the request to the profile page.
     */
    public function profile(): void
    {
        $pdo = Database::getInstance()->getConnection();
        $user = User::getById($pdo, $_SESSION['user_id']);
        $this->render('User/profile', ['user' => $user]);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: /login');
    }


    /**
     * Render a view with optional data.
     *
     * @param array $data Optional data to pass to the view.
     */
    private function render($view = 'home', array $data = []): void
    {// Extract array keys as variables for the view
        try {
            extract($data);

            // Include the view file;
            require_once __DIR__ . "/../Views/$view.php";
        } catch (Exception $e) {
            // If there's an issue with the connection or fetching data, display an error message
            echo "Error: " . $e->getMessage();
            exit;  // Stop further execution if there's an error
        }
    }
}

ob_end_flush();
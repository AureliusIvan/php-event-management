<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Exception;

class AdminController
{
    public function __construct()
    {
        // start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // there is no user session at all, redirect to login
        if ($_SERVER['REQUEST_URI'] !== '/login' &&
            $_SERVER['REQUEST_URI'] !== '/register' &&
            $_SERVER['REQUEST_URI'] !== '/create-user') {
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
                header('Location: /login');
                exit;
            }
        }
    }


    /**
     * @return void
     */
    public function adminDashboard(): void
    {
        $data = [];
        try {
            // get total events, users, and transactions
            $pdo = Database::getInstance()->getConnection();
            $data['total_events'] = Event::getTotalEvents($pdo);
            $data['total_users'] = User::getTotalUsers($pdo);
            $data['total_transactions'] = Transaction::getTotalTransactions($pdo);

            // get all events
            $data['events'] = Event::getAll($pdo);

            // get all users
            $data['users'] = User::getAll($pdo);

            // render the view
            $this->render(
                'Admin/dashboard',
                [
                    'title' => 'Admin Dashboard',
                    'data' => $data
                ]
            );
        } catch (Exception $e) {
            // If there's an issue with the connection or fetching data, display an error message
            echo "Error: " . $e->getMessage();
            exit;  // Stop further execution if there's an error
        }
    }

    public function addNewEvent(): void
    {
        $this->render('Admin/addNewEvent', ['title' => 'Add New Event']);
    }

    public function submitAddNewEvent(): void
    {
        $pdo = Database::getInstance()->getConnection();
        $_POST['date'] = date('Y-m-d', strtotime($_POST['date']));
        $event = new Event($pdo, $_POST);
        $event->save();
        header('Location: /admin');

    }


    /**
     * Render a view with optional data.
     *
     * @param array $data Optional data to pass to the view.
     */
    private function render($view = 'admin', array $data = []): void
    {// Extract array keys as variables for the view
        try {
            extract($data);
            // Include the view file;
            require_once __DIR__ . "/../Views/{$view}.php";
        } catch (Exception $e) {
            // If there's an issue with the connection or fetching data, display an error message
            echo "Error: " . $e->getMessage();
            exit;  // Stop further execution if there's an error
        }
    }
}

ob_end_flush();
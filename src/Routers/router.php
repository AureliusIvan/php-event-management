<?php

use App\Controllers\UserController;
use App\Controllers\AdminController;

$request = $_SERVER['REQUEST_URI'];

if ($request === '/') {
    $controller = new UserController();
    $controller->eventList();
} elseif ($request === '/login') {
    $controller = new UserController();
    $controller->loginPage();
} elseif ($request === '/user-login') {
    $controller = new UserController();
    $controller->userLogin();
} elseif ($request === '/create-user') {
    $controller = new UserController();
    $controller->createUser();
} elseif ($request === '/register') {
    $controller = new UserController();
    $controller->register();
} elseif ($request === '/event-list') {
    $controller = new UserController();
    $controller->eventList();
} elseif (preg_match('#^/event-details\?id=([0-9]+)$#', $request, $matches)) {
    // The event ID is captured in $matches[1]
    $controller = new UserController();
    $controller->eventDetails($matches[1]);  // Pass the ID to the controller
} elseif ($request === '/event-registration') {
    $controller = new UserController();
    $controller->eventRegistration();
} elseif ($request === '/event-registered-list') {
    $controller = new UserController();
    $controller->eventRegisteredListPage();
} elseif ($request === '/event-cancellation') {
    $controller = new UserController();
    $controller->eventCancellation();
} elseif ($request === '/profile') {
    $controller = new UserController();
    $controller->profile();
} elseif ($request === '/logout') {
    $controller = new UserController();
    $controller->logout();
} elseif ($request === '/admin') {
    $controller = new AdminController();
    $controller->adminDashboard();
} elseif ($request === '/admin/add-new-event') {
    $controller = new AdminController();
    $controller->addNewEvent();
} elseif ($request === '/admin/add-new-event/submit') {
    $controller = new AdminController();
    $controller->submitAddNewEvent();
} else {
    http_response_code(404);
    require __DIR__ . '/../Views/404.php';
}

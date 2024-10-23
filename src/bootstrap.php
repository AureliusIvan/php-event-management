<?php
// Enable Composer autoloading
require_once __DIR__ . '/../vendor/autoload.php';


// Load environment variables
use App\Config\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Load configurations
$appConfig = require_once __DIR__ . '/../config/app.php';

// Create a new database connection
$database = Database::getInstance();
$pdo = $database->getConnection();

// Set timezone
date_default_timezone_set($appConfig['timezone']);

// Enable error reporting in debug mode
if ($appConfig['debug']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
}

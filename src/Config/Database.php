<?php

namespace App\Config;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database
{
    // Hold the class instance.
    private static ?Database $instance = null;
    private PDO $pdo;

    // Database credentials
    private $host;
    private $dbname;
    private $user;
    private $pass;
    private $charset;

    // Private constructor to prevent multiple instances
    private function __construct()
    {
        // Load environment variables if not already loaded
        if (!isset($_ENV['DB_HOST'])) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();
        }

        // Set database credentials from environment variables

        // Use getenv() instead of $_ENV
        $this->host = getenv('DB_HOST');
        $this->dbname = getenv('DB_NAME');
        $this->user = getenv('DB_USER');
        $this->pass = getenv('DB_PASS');
        $this->charset = 'utf8mb4';

        // Create a DSN string for the PDO connection
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        // Set PDO options for error handling and security
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            // Create the PDO instance (database connection)
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            // Handle connection error
            // throw the error
            echo $e->getMessage();
            echo '<br>';
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    // The singleton method to get the instance of the database
    public static function getInstance(): ?Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Getter for the PDO connection
    public function getConnection()
    {
        return $this->pdo;
    }

    // Getters for database credentials (if needed)
    public function getHost()
    {
        return $this->host;
    }

    public function getDbName()
    {
        return $this->dbname;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function getCharset()
    {
        return $this->charset;
    }

    // Setters for database credentials (if needed)
    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setDbName($dbname)
    {
        $this->dbname = $dbname;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    public function setCharset($charset)
    {
        $this->charset = $charset;
    }
}
//
//// Usage example
//$db = Database::getInstance();
//$pdo = $db->getConnection();
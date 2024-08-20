<?php

class Database {
    private $host = "localhost";
    private $db_name = "blog_db";
    private $username = "root";
    private $password = "";
    public $pdo;

    // Method to establish a database connection
    public function getConnection() {
        $this->pdo = null;

        try {
            $this->pdo = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->pdo;
    }

    // Method to execute SQL queries (e.g., INSERT, UPDATE, DELETE)
    public function executeQuery($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->rowCount(); // Returns the number of affected rows
        } catch(PDOException $exception) {
            echo "Query error: " . $exception->getMessage();
            return false;
        }
    }

    // Method to fetch results from SQL queries (e.g., SELECT)
    public function fetchResults($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns results as an associative array
        } catch(PDOException $exception) {
            echo "Query error: " . $exception->getMessage();
            return false;
        }
    }

    public function executeScript($file) {
        $sql = file_get_contents($file);

        if ($sql === false) {
            echo "Error reading the SQL file.";
            return false;
        }

        try {
            $this->pdo->exec($sql);
            echo "Script executed successfully.";
        } catch(PDOException $exception) {
            echo "Script execution error: " . $exception->getMessage();
            return false;
        }
    }
}
?>

<?php

class DatabaseConnection {
    private $conn;

    public function __construct($host, $username, $password, $database) {
    
        $this->conn = new mysqli($host, $username, $password, $database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function execute($query) {
        $result = $this->conn->query($query);
        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }
        return $result;
    }

    public function prepare($statement){
        return mysqli_prepare($this->conn, $statement);
    }

    public function escape($value) {
        //return mysqli_real_escape_string($this->conn,$value);
        return $this->conn->real_escape_string($value);
    }

    public function close() {
        $this->conn->close();
    }
}
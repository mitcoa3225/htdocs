<?php
// Database connection class.
// Creates the connection used by the DB functions.
// Stores connection status and errors.

class Database {

    private $conn;
    private $error;

    //constructor
    public function __construct() {

        // Connection settings
        $host = "localhost";
        $user = "root";
        $password = "";
        $dbName = "velocitynet_db";

        $this->error = "";
        $this->conn = mysqli_connect($host, $user, $password, $dbName);

        // If connection fails, store the error so the caller can handle it.
        if ($this->conn == false) {
            $this->error = mysqli_connect_error();
        }
    }

    //get db conn
    public function getDbConn() {
        return $this->conn;
    }

    //get error
    public function getError() {
        return $this->error;
    }

    //run   destruct
    public function __destruct() {

        // Close the DB connection when the object is destroyed.
        if ($this->conn != false) {
            mysqli_close($this->conn);
        }
    }
}
?>
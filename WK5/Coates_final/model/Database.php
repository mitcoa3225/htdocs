<?php
namespace Models;

use Utils\Config;

class Database {
    private string $host;
    private string $dbname;
    private string $username;
    private string $password;

    private $conn;
    private string $conn_error = '';

    public function __construct() {
        $this->host = Config::dbHost();
        $this->dbname = Config::dbName();
        $this->username = Config::dbUser();
        $this->password = Config::dbPass();

        mysqli_report(MYSQLI_REPORT_OFF);
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn === false) {
            $this->conn_error = 'Failed to connect to DB: ' . mysqli_connect_error();
        }
    }

    public function __destruct() {
        if ($this->conn) mysqli_close($this->conn);
    }

    public function getDbConn() { return $this->conn; }
    public function getDbError(): string { return $this->conn_error; }

    public function getDbHost(): string { return $this->host; }
    public function getDbName(): string { return $this->dbname; }
    public function getDbUser(): string { return $this->username; }
    public function getDbPass(): string { return $this->password; }
}

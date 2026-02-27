<?php
namespace Models;

class Database {
  // DB connection parameters
  private $host = 'localhost';
  private $dbname = 'sdc342_wk3midterm';

  // TODO: update these to match the SQL file credentials
  private $username = 'root';
  private $password = '';

  // DB connection and error message
  private $conn;
  private $conn_error = '';

  function __construct() {
    // turn off error reporting since we're handling errors manually
    mysqli_report(MYSQLI_REPORT_OFF);

    $this->conn = mysqli_connect(
      $this->host,
      $this->username,
      $this->password,
      $this->dbname
    );

    if ($this->conn === false) {
      $this->conn_error = "Failed to connect to DB: " . mysqli_connect_error();
    }
  }

  function __destruct() {
    if ($this->conn) {
      mysqli_close($this->conn);
    }
  }

  // return the connection; if the connection failed, it will be false
  function getDbConn() {
    return $this->conn;
  }

  function getDbError() {
    return $this->conn_error;
  }

  // getters for connection info
  function getDbHost() { return $this->host; }
  function getDbName() { return $this->dbname; }
  function getDbUser() { return $this->username; }
  function getDbPass() { return $this->password; }
}

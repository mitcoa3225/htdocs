<?php
require_once(__DIR__ . '\database.php');

//class for doing roles table queries; only gets all
//existing roles for now
class RoleDB {
 //Get all roles in the DB; returns false if the
 //database connection fails
 public static function geRoles() {
 //get the DB connection
 $db = new Database();
 $dbConn = $db->getDbConn();

 if ($dbConn) {
 //create the query string
 $query = 'SELECT * FROM roles';

 //execute the query
 return $dbConn->query($query);
        } else {
 return false;
        }
    }
}
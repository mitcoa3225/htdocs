<?php
require_once(__DIR__.'\database.php');

//class for users table queries
class UsersDB {
 //function to get a user by their e-mail address
 public static function getUserByEMail($email) {
 //get the DB connection
 $db = new Database();
 $dbConn = $db->getDbConn();

 if ($dbConn) {
 //create the query string
 $query = "SELECT * FROM users
 WHERE users.EMail = '$email'";

 //execute the query - returns false if
 //no such email found
 $result = $dbConn->query($query);
 return $result->fetch_assoc();
        } else {
 return false;
        }
    }
}
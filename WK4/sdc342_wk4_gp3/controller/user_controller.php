<?php
require_once(__DIR__.'\..\model\user_db.php');
require_once(__DIR__.'\user.php');

class UserController {
 //helper function to convert a db row into a
 //User object
 private static function rowToUser($row) {
 $user = new User($row['FirstName'],
 $row['LastName'],
 $row['EMail'],
 $row['Password'],
 $row['RegistrationDate'],
 $row['UserLevel'],
 $row['UserId']);
 return $user;
    }

 //function to check login credentials - return the
 //user's level if valid, false otherwise
 public static function validUser($email, $password) {
 $queryRes = UsersDB::getUserByEMail($email);
 if ($queryRes) {
 //process the user row
 $user = self::rowToUser($queryRes);
 if ($user->getPassword() === $password) {
 return $user->getUserLevel();
            } else {
 return false;
            }
        } else {
 //either no such user or db connect failed - 
 //either way, can't validate the user
 return false;
        }
    }
} 
<?php
include_once(__DIR__ . '\role.php');
include_once(__DIR__ . '\..\model\role_db.php');

class RoleController {
 public static function getAllRoles() {
 $queryRes = RoleDB::geRoles();

 if ($queryRes) {
 //process the results into an array of 
 //Role objects
 $roles = array();

 foreach ($queryRes as $row) {
 $roles[] = new Role($row['RoleNo'], 
 $row['RoleName']);
            }

 //return the array of Role information
 return $roles;
        } else {
 return false;
        }
    }
}
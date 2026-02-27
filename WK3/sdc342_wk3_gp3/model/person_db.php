<?php
require_once(__DIR__ . '\database.php');

//class for doing queries on the people table; provides
//functions for getting all people, getting people by
//their role, getting an individual person, adding a
//person, updating a person, and deleting a person
class PersonDB {
 //Get all people in the DB; returns false if the
 //database connection fails
 public static function getPeople() {
 //get the DB connection
 $db = new Database();
 $dbConn = $db->getDbConn();

 if ($dbConn) {
 //create the query string; join the person
 //table with the roles table to get the role
 //info for the person object
 $query = 'SELECT * FROM people 
                      INNER JOIN roles 
                          ON people.RoleNo = roles.RoleNo';

 //execute the query
 return $dbConn->query($query);
        } else {
 return false;
        }
    }

 //function to get all people in a specific role; 
 //returns false if the database connection fails
 public static function getPeopleByRole($roleNo) {
 //get the DB connection
 $db = new Database();
 $dbConn = $db->getDbConn();
 if ($dbConn) {
 //create the query string
 $query = "SELECT * FROM people
 INNER JOIN roles
 ON people.RoleNo = roles.RoleNo
 WHERE people.RoleNo = '$roleNo'";

 //execute the query
 return $dbConn->query($query);
        } else {
 return false;
        }
    }

 //function to get a specific person by their PersonNo
 public static function getPerson($personNo) {
 //get the database connection
 $db = new Database();
 $dbConn = $db->getDbConn();
 if ($dbConn) {
 //create the query string
 $query = "SELECT * FROM people
 INNER JOIN roles
 ON people.RoleNo = roles.RoleNo
 WHERE PersonNo = '$personNo'";

 //execute the query
 $result = $dbConn->query($query);

 //return the associative array
 return $result->fetch_assoc();
        } else {
 return false;
        }
    }

 //function to delete a person by their PersonNo
 //returns True on success, False on failure or 
 //datbase connection failure
 public static function deletePerson($personNo) {
 //get the database connection
 $db = new Database();
 $dbConn = $db->getDbConn();

 if ($dbConn) {
 //create the query string
 $query = "DELETE FROM people
 WHERE PersonNo = '$personNo'";

 //execute the query, returning status
 return $dbConn->query($query) === TRUE; 
        } else {
 return false;
        }
    }

 //function to add a person to the DB; returns
 //true on success, false on failure or DB connection
 //failure
 public static function addPerson($fName, $lName,
 $start, $roleNo) 
    {
 //get the database connection
 $db = new Database();
 $dbConn = $db->getDbConn();

 if ($dbConn) {
 //create the query string - PersonNo is an
 //auto-increment field, so no need to 
 //specify it
 $query = 
 "INSERT INTO people (PersonFirstName, 
                PersonLastName, PersonStartDate, RoleNo)
 VALUES ('$fName', '$lName', '$start', '$roleNo')";
 //execute the query, returning status
 return $dbConn->query($query) === TRUE; 
        } else {
 return false;
        }
    }

 //function to update a person's information; returns
 //true on success, false on failure or DB connection
 //failure
 public static function updatePerson($pNo, $fName, 
 $lName, $start, $roleNo) 
    {
 //get the database connection
 $db = new Database();
 $dbConn = $db->getDbConn();

 if ($dbConn) {
 //create the query string
 $query = 
 "UPDATE people SET 
                PersonFirstName = '$fName', 
                PersonLastName = '$lName', 
                PersonStartDate = '$start', 
                RoleNo = '$roleNo'
 WHERE PersonNo = '$pNo'";

 //execute the query, returning status
 return $dbConn->query($query) === TRUE; 
        } else {
 return false;
        }
    }
}
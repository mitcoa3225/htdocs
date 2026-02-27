<?php
include_once(__DIR__ . '\person.php');
include_once(__DIR__ . '\..\model\person_db.php');

class PersonController {
 //helper function for taking all information
 //from a person info query (row) and converting
 //it into a Person object
 private static function rowToPerson($row) {
 $person = new Person($row['PersonFirstName'],
 $row['PersonLastName'],
 $row['PersonStartDate'],
 new Role($row['RoleNo'],
 $row['RoleName']));
 $person->setPersonNo($row['PersonNo']);
 return $person;
    }

 //function to get all people in the database
 public static function getAllPeople() {
 $queryRes = PersonDB::getPeople();

 if ($queryRes) {
 //process the results into an array with
 //the RoleNo and the RoleName - allows the
 //UI to not care about the DB structure
 $people = array();

 foreach ($queryRes as $row) {
 //process each row into an array of
 //Person objects (i.e. "people")
 $people[] = self::rowToPerson($row);
            }
 return $people;
        } else {
 return false;
        }
    }

 //function to get people in a specific role
 public static function getPeopleByRole($roleNo) {
 $queryRes = PersonDB::getPeopleByRole($roleNo);

 if ($queryRes) {
 $people = array();

 foreach ($queryRes as $row) {
 $people[] = self::rowToPerson($row);
            }

 return $people;
        } else {
 return false;
        }
    }

 //function to get a specific person by their PersonNo
 public static function getPersonByNo($personNo) {
 $queryRes = PersonDB::getPerson($personNo);

 if ($queryRes) {
 //this query only returns a single row, so
 //just process it
 return self::rowToPerson($queryRes);
        } else {
 return false;
        }
    }

 //function to delete a person by their PersonNo
 public static function deletePerson($personNo) {
 //no special processing needed - just use the 
 //DB function
 return PersonDB::deletePerson($personNo); 
    }

 //function to add a person to the DB
 public static function addPerson($person) {
 return PersonDB::addPerson(
 $person->getFirstName(),
 $person->getLastName(),
 $person->getStartDate(),
 $person->getRole()->getRoleNo());
    }

 //function to update a person's information
 public static function updatePerson($person) {
 return PersonDB::updatePerson(
 $person->getPersonNo(),
 $person->getFirstName(),
 $person->getLastName(),
 $person->getStartDate(),
 $person->getRole()->getRoleNo());
    }
}
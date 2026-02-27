<?php
//Person class to represent a single entry in the People table
class Person {
 //class properties - match the columns in the
 //People table with one exception - the DB stores
 //roleNo - for the person class we want both the
 //roleNo and the roleName, so we'll just store
 //a Role class object
 private $personNo;
 private $personFirstName;
 private $personLastName;
 private $personStartDate;
 private $role;

 public function __construct($personFirstName, 
 $personLastName, $personStartDate, $role) 
    {
 $this->personFirstName = $personFirstName;
 $this->personLastName = $personLastName;
 $this->personStartDate = $personStartDate;
 $this->role = $role;
    }

 //get and set the person properties
 public function getPersonNo() {
 return $this->personNo;
    }
 public function setPersonNo($value) {
 $this->personNo = $value;
    }
 public function getFirstName() {
 return $this->personFirstName;
    }
 public function setFirstName($value) {
 $this->personFirstName = $value;
    }
 public function getLastName() {
 return $this->personLastName;
    }
 public function setLastName($value) {
 $this->personLastName = $value;
    }
 public function getStartDate() {
 return $this->personStartDate;
    }
 public function setStartDate($value) {
 $this->personStartDate = $value;
    }

 //get and set the role property
 public function getRole() {
 return $this->role;
    }
 public function setRole($value) {
 $this->role = $value;
    }
}
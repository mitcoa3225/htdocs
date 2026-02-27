<?php
class DisplayName {

 //properties
 private $first_name;
 private $last_name;

 //constructor - note the word "construct"
 // is preceded by 2 underscores
 function __construct($fName, $lName) {
 //set the member properties to the values provided
 $this->first_name = $fName;
 $this->last_name = $lName;
    }

 //property get/set methods
 function setFirstName($first) {
 $this->first_name = $first;
    }

 function getFirstName() {
 return $this->first_name;
    }

 function setLastName($last) {
 $this->last_name = $last;
    }

 function getLastName() {
 return $this->last_name;
    }

 //class methods
 function getFullName() {
 return $this->first_name . " " . $this->last_name;
    }
}
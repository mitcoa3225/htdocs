<?php
class DisplayName {
 //properties
 private $first_name;
 private $last_name;

 //methods
 function setName($first, $last) {
 $this->first_name = $first;
 $this->last_name = $last;
    }

 function getName() {
 return $this->first_name . " " . $this->last_name;
    }
}
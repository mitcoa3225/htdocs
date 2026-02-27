<?php
/*
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
*/
class Person {
   private $first_name;
   private $last_name;
   private $address1;
   private $address2;
   private $city;
   private $state;
   private $zip_code;
   function __construct($FName, $LName, $Address1, $Address2, $City, $State, $ZipCode) {
      $this->first_name = $FName;
      $this->last_name = $LName;
      $this->address1 = $Address1;
      $this->address2 = $Address2;
      $this->city = $City;
      $this->state = $State;
      $this->zip_code = $ZipCode;
   }
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
   

   function setAddress1($address1) {
      return $this->address1= $address1;
   }
   function getAddress1() {
      return $this->address1;
   }
   function setAddress2($Address2) {
      $this->address2 = $Address2;
   }
   function getAddress2(){
      return $this->address2;
   }
   function setCity($City){
      $this->city =$City;
   }
   function getCity() {
      return $this->city;
   }
   function setState($State){
      $this->state = $State;
   }
   function getState(){
      return $this->state;
   }
   function setZip($zipCode) {
      $this->zip_code = $zipCode;
   }
   function getZip(){
      return $this->zip_code;
   }
   /*   
   function getFullName() {
   return $this->first_name . " " . $this->last_name;
      }*/

   // "Last, First"
   function getFormattedName(){
      return $this->last_name . ", " . $this->first_name;
   }
   // "Address1, Address2" or "Address 1"
   function getFormattedAddress(){
      if (trim($this->address2) === ""){
         return $this->address1;
      } else {
         return $this->address1 . ", " . $this->address2;
      }
   }
   // "City, State Zip"
   function getFormattedAddressLocation(){
      return $this->city.", ".$this->state." ".$this->zip_code;
   }
   static function getHeaderMessage(){
      return "Name and Address Information";
   }
   
   static function getFullNameLabel(){
      return "Full Name";
   }
   static function getAddressLabel(){
      return "Address";
   }
   static function getCityStateZipLabel(){
      return "City/State/Zip";
   }
}

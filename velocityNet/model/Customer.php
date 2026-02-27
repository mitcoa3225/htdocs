<?php
// Customer class.
// Stores values for this object.


class Customer {

    private $customerId;
    private $email;
    private $firstName;
    private $lastName;
    private $streetAddress;
    private $city;
    private $state;
    private $zipCode;
    private $phoneNumber;
    private $passwordHash;

    //constructor 
    public function __construct($email, $firstName, $lastName, $streetAddress, $city, $state, $zipCode, $phoneNumber, $passwordHash) {
        $this->customerId = 0;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->streetAddress = $streetAddress;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
        $this->phoneNumber = $phoneNumber;
        $this->passwordHash = $passwordHash;
    }

    //getter/setters
    public function getCustomerId() { return $this->customerId; }
    public function setCustomerId($value) { $this->customerId = $value; }

    public function getEmail() { return $this->email; }
    public function setEmail($value) { $this->email = $value; }

    public function getFirstName() { return $this->firstName; }
    public function setFirstName($value) { $this->firstName = $value; }

    public function getLastName() { return $this->lastName; }
    public function setLastName($value) { $this->lastName = $value; }

    public function getStreetAddress() { return $this->streetAddress; }
    public function setStreetAddress($value) { $this->streetAddress = $value; }

    public function getCity() { return $this->city; }
    public function setCity($value) { $this->city = $value; }

    public function getState() { return $this->state; }
    public function setState($value) { $this->state = $value; }

    public function getZipCode() { return $this->zipCode; }
    public function setZipCode($value) { $this->zipCode = $value; }

    public function getPhoneNumber() { return $this->phoneNumber; }
    public function setPhoneNumber($value) { $this->phoneNumber = $value; }

    public function getPasswordHash() { return $this->passwordHash; }
    public function setPasswordHash($value) { $this->passwordHash = $value; }
}
?>
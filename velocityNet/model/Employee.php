<?php
// Employee class.
// Stores values for this object.

class Employee {

    private $employeeId;
    private $email;
    private $firstName;
    private $lastName;
    private $role;
    private $passwordHash;

    //constructor 
    public function __construct($email, $firstName, $lastName, $role, $passwordHash) {
        $this->employeeId = 0;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
        $this->passwordHash = $passwordHash;
    }

    //getter/setter to get and set employee id
    public function getEmployeeId() { return $this->employeeId; }
    public function setEmployeeId($value) { $this->employeeId = $value; }

    //getter/setter to get and set email
    public function getEmail() { return $this->email; }
    public function setEmail($value) { $this->email = $value; }

    //getter/setter to get and set first name
    public function getFirstName() { return $this->firstName; }
    public function setFirstName($value) { $this->firstName = $value; }

    //getter/setter to get and set last name
    public function getLastName() { return $this->lastName; }
    public function setLastName($value) { $this->lastName = $value; }

    //getter/setter to get and set role
    public function getRole() { return $this->role; }
    public function setRole($value) { $this->role = $value; }

    //getter/setter to get and set password hash
    public function getPasswordHash() { return $this->passwordHash; }
    public function setPasswordHash($value) { $this->passwordHash = $value; }
}
?>
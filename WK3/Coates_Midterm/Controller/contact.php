<?php
namespace Controllers;

class Contact {
  private $ContactNo;
  private $ContactFirstName;
  private $ContactLastName;
  private $ContactAddressLine1;
  private $ContactAddressLine2;
  private $ContactCity;
  private $ContactState;
  private $ContactZip;
  private $ContactBirthdate;
  private $ContactEMail;
  private $ContactPhone;
  private $ContactNotes;

  function __construct(
    $firstName, $lastName, $address1, $address2, $city, $state, $zip,
    $birthdate, $email, $phone, $notes, $contactNo = 0
  ) {
    $this->ContactNo = (int)$contactNo;
    $this->ContactFirstName = $firstName;
    $this->ContactLastName = $lastName;
    $this->ContactAddressLine1 = $address1;
    $this->ContactAddressLine2 = $address2;
    $this->ContactCity = $city;
    $this->ContactState = $state;
    $this->ContactZip = $zip;
    $this->ContactBirthdate = $birthdate;
    $this->ContactEMail = $email;
    $this->ContactPhone = $phone;
    $this->ContactNotes = $notes;
  }

  function getContactNo() { return $this->ContactNo; }
  function setContactNo($v) { $this->ContactNo = (int)$v; }

  function getFirstName() { return $this->ContactFirstName; }
  function setFirstName($v) { $this->ContactFirstName = $v; }

  function getLastName() { return $this->ContactLastName; }
  function setLastName($v) { $this->ContactLastName = $v; }

  function getAddress1() { return $this->ContactAddressLine1; }
  function setAddress1($v) { $this->ContactAddressLine1 = $v; }

  function getAddress2() { return $this->ContactAddressLine2; }
  function setAddress2($v) { $this->ContactAddressLine2 = $v; }

  function getCity() { return $this->ContactCity; }
  function setCity($v) { $this->ContactCity = $v; }

  function getState() { return $this->ContactState; }
  function setState($v) { $this->ContactState = $v; }

  function getZip() { return $this->ContactZip; }
  function setZip($v) { $this->ContactZip = $v; }

  function getBirthdate() { return $this->ContactBirthdate; }
  function setBirthdate($v) { $this->ContactBirthdate = $v; }

  function getEmail() { return $this->ContactEMail; }
  function setEmail($v) { $this->ContactEMail = $v; }

  function getPhone() { return $this->ContactPhone; }
  function setPhone($v) { $this->ContactPhone = $v; }

  function getNotes() { return $this->ContactNotes; }
  function setNotes($v) { $this->ContactNotes = $v; }

  function getNameFormatted() {
    return $this->ContactLastName . ", " . $this->ContactFirstName;
  }
}

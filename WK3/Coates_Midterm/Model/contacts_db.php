<?php
namespace Models;

require_once(__DIR__ . '.\database.php');

class ContactsDB {

  public static function getAllContacts() {
    $db = new Database();
    $conn = $db->getDbConn();
    if ($conn === false) { return false; }

    $sql = "SELECT * FROM contacts ORDER BY ContactNo";
    $result = mysqli_query($conn, $sql);
    if ($result === false) { return []; }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  public static function getContactByNo($contactNo) {
    $db = new Database();
    $conn = $db->getDbConn();
    if ($conn === false) { return false; }

    $contactNo = (int)$contactNo;
    $sql = "SELECT * FROM contacts WHERE ContactNo = $contactNo";
    $result = mysqli_query($conn, $sql);
    if ($result === false) { return null; }

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (count($rows) === 0) { return null; }
    return $rows[0];
  }

  public static function addContact($c) {
    $db = new Database();
    $conn = $db->getDbConn();
    if ($conn === false) { return false; }

    // escape all values to prevent SQL injection
    $fn = mysqli_real_escape_string($conn, $c->getFirstName());
    $ln = mysqli_real_escape_string($conn, $c->getLastName());
    $a1 = mysqli_real_escape_string($conn, $c->getAddress1());
    $a2 = mysqli_real_escape_string($conn, $c->getAddress2());
    $city = mysqli_real_escape_string($conn, $c->getCity());
    $state = mysqli_real_escape_string($conn, $c->getState());
    $zip = mysqli_real_escape_string($conn, $c->getZip());
    $dob = mysqli_real_escape_string($conn, $c->getBirthdate());
    $email = mysqli_real_escape_string($conn, $c->getEmail());
    $phone = mysqli_real_escape_string($conn, $c->getPhone());
    $notes = mysqli_real_escape_string($conn, $c->getNotes());

    $sql = "INSERT INTO contacts
      (ContactFirstName, ContactLastName, ContactAddressLine1, ContactAddressLine2,
       ContactCity, ContactState, ContactZip, ContactBirthdate,
       ContactEMail, ContactPhone, ContactNotes)
      VALUES
      ('$fn', '$ln', '$a1', '$a2', '$city', '$state', '$zip', '$dob', '$email', '$phone', '$notes')";

    return mysqli_query($conn, $sql);
  }
  
  public static function updateContact($c) {
    $db = new Database();
    $conn = $db->getDbConn();
    if ($conn === false) { return false; }

    $no = (int)$c->getContactNo();
    // escape all values to prevent SQL injection
    $fn = mysqli_real_escape_string($conn, $c->getFirstName());
    $ln = mysqli_real_escape_string($conn, $c->getLastName());
    $a1 = mysqli_real_escape_string($conn, $c->getAddress1());
    $a2 = mysqli_real_escape_string($conn, $c->getAddress2());
    $city = mysqli_real_escape_string($conn, $c->getCity());
    $state = mysqli_real_escape_string($conn, $c->getState());
    $zip = mysqli_real_escape_string($conn, $c->getZip());
    $dob = mysqli_real_escape_string($conn, $c->getBirthdate());
    $email = mysqli_real_escape_string($conn, $c->getEmail());
    $phone = mysqli_real_escape_string($conn, $c->getPhone());
    $notes = mysqli_real_escape_string($conn, $c->getNotes());

    $sql = "UPDATE contacts SET
      ContactFirstName='$fn',
      ContactLastName='$ln',
      ContactAddressLine1='$a1',
      ContactAddressLine2='$a2',
      ContactCity='$city',
      ContactState='$state',
      ContactZip='$zip',
      ContactBirthdate='$dob',
      ContactEMail='$email',
      ContactPhone='$phone',
      ContactNotes='$notes'
      WHERE ContactNo=$no";

    return mysqli_query($conn, $sql);
  }

  public static function deleteContact($contactNo) {
    $db = new Database();
    $conn = $db->getDbConn();
    if ($conn === false) { return false; }

    $contactNo = (int)$contactNo;
    $sql = "DELETE FROM contacts WHERE ContactNo = $contactNo";
    return mysqli_query($conn, $sql);
  }
}

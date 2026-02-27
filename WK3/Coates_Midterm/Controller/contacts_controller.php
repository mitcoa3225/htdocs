<?php
namespace Controllers;

require_once(__DIR__ . '\contact.php');
require_once(__DIR__ . '\..\Model\contacts_db.php');

use Models\ContactsDB;

class ContactsController {

  public static function getAllContacts() {
    return ContactsDB::getAllContacts();
  }

  public static function getContactByNo($contactNo) {
    return ContactsDB::getContactByNo($contactNo);
  }

  public static function addContact($contactObj) {
    return ContactsDB::addContact($contactObj);
  }

  public static function updateContact($contactObj) {
    return ContactsDB::updateContact($contactObj);
  }

  public static function deleteContact($contactNo) {
    return ContactsDB::deleteContact($contactNo);
  }
}

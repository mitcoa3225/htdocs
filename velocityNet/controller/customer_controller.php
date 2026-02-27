<?php
// Customer controller.
// Keeps customer database work in one place.

require_once(__DIR__ . "/../model/customerDB.php");
require_once(__DIR__ . "/../model/complaintDB.php");

class CustomerController {

    // Get all customers.
    public static function getAllCustomers() {
        return CustomerDB::getAllCustomers();
    }

    // Get one customer by id.
    public static function getCustomerById($customerIdNumber) {
        return CustomerDB::getCustomerById((int)$customerIdNumber);
    }

    // Add a customer.
    public static function addCustomer($emailText, $firstNameText, $lastNameText, $streetText, $cityText, $stateText, $zipCodeText, $phoneNumberText, $passwordText = "") {
        // Store passwords hashed in the database.
        $passwordHashText = "";
        if ($passwordText !== "") {
            $passwordHashText = password_hash((string)$passwordText, PASSWORD_DEFAULT);
        }

        return CustomerDB::insertCustomer($emailText, $firstNameText, $lastNameText, $streetText, $cityText, $stateText, $zipCodeText, $phoneNumberText, $passwordHashText);
    }

    // Update a customer's password.
    public static function updateCustomerPassword($customerIdNumber, $passwordText) {
        $passwordHashText = password_hash((string)$passwordText, PASSWORD_DEFAULT);
        return CustomerDB::updateCustomerPassword((int)$customerIdNumber, $passwordHashText);
    }

    // Update a customer.
    public static function updateCustomer($customerIdNumber, $emailText, $firstNameText, $lastNameText, $streetText, $cityText, $stateText, $zipCodeText, $phoneNumberText) {
        return CustomerDB::updateCustomer((int)$customerIdNumber, $emailText, $firstNameText, $lastNameText, $streetText, $cityText, $stateText, $zipCodeText, $phoneNumberText);
    }

    // Delete a customer.
    // Complaints must be removed first to avoid foreign key issues.
    public static function deleteCustomer($customerIdNumber) {

        $customerIdNumber = (int)$customerIdNumber;
        if ($customerIdNumber <= 0) return false;

        // Delete related complaints first (ok if zero rows).
        $ok = ComplaintDB::deleteComplaintsByCustomerId($customerIdNumber);
        if ($ok == false) return false;

        return CustomerDB::deleteCustomer($customerIdNumber);
    }
}

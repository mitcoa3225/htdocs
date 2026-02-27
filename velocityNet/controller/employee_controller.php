<?php
// Employee controller.
// Keeps employee database work in one place.

require_once(__DIR__ . "/../model/employeesDB.php");
require_once(__DIR__ . "/../model/complaintDB.php");

class EmployeeController {

    // Get all employees.
    public static function getAllEmployees() {
        return EmployeeDB::getAllEmployees();
    }

    // Get one employee by id.
    public static function getEmployeeById($employeeIdNumber) {
        return EmployeeDB::getEmployeeById((int)$employeeIdNumber);
    }

    // Add an employee.
    public static function addEmployee($emailText, $firstNameText, $lastNameText, $roleText, $passwordText) {
        // Store passwords hashed in the database.
        $passwordHashText = password_hash((string)$passwordText, PASSWORD_DEFAULT);
        return EmployeeDB::insertEmployee($emailText, $firstNameText, $lastNameText, $roleText, $passwordHashText);
    }

    // Update an employee password.
    public static function updateEmployeePassword($employeeIdNumber, $passwordText) {
        $passwordHashText = password_hash((string)$passwordText, PASSWORD_DEFAULT);
        return EmployeeDB::updateEmployeePassword((int)$employeeIdNumber, $passwordHashText);
    }

    // Update an employee.
    public static function updateEmployee($employeeIdNumber, $emailText, $firstNameText, $lastNameText, $roleText) {
        return EmployeeDB::updateEmployee((int)$employeeIdNumber, $emailText, $firstNameText, $lastNameText, $roleText);
    }

    // Delete an employee.
    // Any assigned complaints should be cleared first so the delete will work.
    public static function deleteEmployee($employeeIdNumber) {

        $employeeIdNumber = (int)$employeeIdNumber;
        if ($employeeIdNumber <= 0) return false;

        $ok = ComplaintDB::clearEmployeeFromComplaints($employeeIdNumber);
        if ($ok == false) return false;

        return EmployeeDB::deleteEmployee($employeeIdNumber);
    }

    
}
